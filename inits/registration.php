<?php
ob_start();

// CUSTOM REGISTRATION //
add_action('init', 'custom_user_registration');
function custom_user_registration() {
    global $registration_errors, $username, $email, $phone_number, $subscribe_level, $first_name, $last_name;
    
    $registration_errors = new WP_Error();

    if ('POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST['submit']) && isset($_POST['registration_form'])) {
        $username = sanitize_user($_POST['username']);
        $email = sanitize_email($_POST['email']);
        $password = $_POST['password'];
        $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
        $phone_number = isset($_POST['phone_number']) ? sanitize_text_field($_POST['phone_number']) : '';
        $subscribe_level = isset($_POST['subscribe_level']) ? sanitize_text_field($_POST['subscribe_level']) : '';
        $first_name = isset($_POST['first_name']) ? sanitize_text_field($_POST['first_name']) : '';
        $last_name = isset($_POST['last_name']) ? sanitize_text_field($_POST['last_name']) : '';

        // Validate username
        if (empty($username) || !validate_username($username) || username_exists($username)) {
            $registration_errors->add('username', 'Username je nepostojeći ili već zauzet.');
        }

        // Validate email
        if (empty($email) || !is_email($email) || email_exists($email)) {
            $registration_errors->add('email', 'Email je nepostojeći ili već zauzet.');
        }

        // Validate password
        if (empty($password) || $password !== $confirm_password) {
            $registration_errors->add('password', 'Password je obavezan i mora se poklapati sa potvrdom.');
        }

        if (empty($phone_number)) {
            $registration_errors->add('phone_number', 'Broj telefona je obavezno polje.');
        }

        if (empty($subscribe_level)) {
            $registration_errors->add('subscribe_level', 'Nivo pretplate je obavezno polje.');
        }

        if (empty($first_name)) {
            $registration_errors->add('first_name', 'Ime je obavezno polje.');
        }

        if (empty($last_name)) {
            $registration_errors->add('last_name', 'Prezime je obavezno polje.');
        }

        if (empty($registration_errors->errors)) {
            // Create user
            $user_id = wp_create_user($username, $password, $email);

            if (!is_wp_error($user_id)) {
                // Update standard WordPress user fields add role contributor
                wp_update_user([
                    'ID' => $user_id,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'role' => 'contributor',
                ]);

                // Update ACF fields
                update_field('phone_number', $phone_number, 'user_' . $user_id);
                update_field('subscribe_level', $subscribe_level, 'user_' . $user_id);

                // Send email to the user

                $s_e_to = $email;
                $s_e_subject = 'In Memoriam - Uspešna registracija';
                $s_e_message = "<h1>Poštovani/a," . $first_name . " " . $last_name . "</h1><br><p>Uspešno ste se registrovali na našem sajtu. Vaši podaci su:</p><br><p>Username: " . $username . "</p><br><p>Email: " . $email . "</p><br><p>Sifra: vasa odabrana.</p><p>Nivo pretplate:" . $subscribe_level . "</p><br><p>Stupicemo u kontakt sa Vama putem telefona ili email-a što pre možemo.</p>";
                $s_e_message .= "<br><p>Hvala Vam na poverenju.</p>";

                $s_e_headers = array('Content-Type: text/html; charset=UTF-8');

                if ( wp_mail($s_e_to, $s_e_subject, $s_e_message, $s_e_headers) ) {
                    wp_redirect(home_url('/uspesna-registracija/'));
                } else {
                    wp_redirect(home_url('/neeeeuspesna-registracija/'));
                }
                
                exit;
            } else {
                $registration_errors->add('registration', $user_id->get_error_message());
            }
        }
    }
}

add_shortcode('custom_registration_form', 'custom_registration_form_shortcode');
function custom_registration_form_shortcode() {
    global $registration_errors, $username, $email, $phone_number, $subscribe_level, $first_name, $last_name;

    // Redirect logged-in non-admin users to their profile page
    if (is_user_logged_in() && !current_user_can('administrator')) {
        wp_redirect(get_author_posts_url(get_current_user_id()));
        exit;
    }

    // Retrieve the posted values or set defaults
    $first_name = isset($_POST['first_name']) ? esc_attr($_POST['first_name']) : '';
    $last_name = isset($_POST['last_name']) ? esc_attr($_POST['last_name']) : '';

    ob_start();
    ?>
    <style>
        .error-field {
            border: 2px solid red;
        }
        .error-message {
            color: red;
            font-size: 0.9em;
        }
    </style>
    <section class="form-holder">
        <div class="wrapper">
            <div class="holder">
                <div class="registration-form custom-forms">
                    <form id="custom-registration-form" action="" method="post">
        
                        <input type="hidden" name="registration_form" value="1">
                        
                        <p class="half animated anim_y">
                            <label for="first_name">Ime*</label>
                            <input type="text" name="first_name" id="first_name" value="<?php echo $first_name; ?>" required>
                        </p>
                        <p class="half animated anim_y">
                            <label for="last_name">Prezime*</label>
                            <input type="text" name="last_name" id="last_name" value="<?php echo $last_name; ?>" required>
                        </p>
                        <p class="half animated anim_y">
                            <label for="username">Username*</label>
                            <input type="text" name="username" id="username" class="<?php echo $registration_errors->get_error_message('username') ? 'error-field' : ''; ?>" value="<?php echo $username; ?>" required>
                            <?php if ($registration_errors->get_error_message('username')): ?>
                                <span class="error-message"><?php echo $registration_errors->get_error_message('username'); ?></span>
                            <?php endif; ?>
                        </p>
                        <p class="half animated anim_y">
                            <label for="email">Email*</label>
                            <input type="email" name="email" id="email" class="<?php echo $registration_errors->get_error_message('email') ? 'error-field' : ''; ?>" value="<?php echo $email; ?>" required>
                            <?php if ($registration_errors->get_error_message('email')): ?>
                                <span class="error-message"><?php echo $registration_errors->get_error_message('email'); ?></span>
                            <?php endif; ?>
                        </p>
                        <p class="half animated anim_y">
                            <label for="password">Šifra*</label>
                            <input type="password" name="password" id="password" class="<?php echo $registration_errors->get_error_message('password') ? 'error-field' : ''; ?>" required>
                            <?php if ($registration_errors->get_error_message('password')): ?>
                                <span class="error-message"><?php echo $registration_errors->get_error_message('password'); ?></span>
                            <?php endif; ?>
                        </p>
                        <p class="half animated anim_y">
                            <label for="confirm_password">Ponovite Šifru*</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="<?php echo $registration_errors->get_error_message('password') ? 'error-field' : ''; ?>" required>
                        </p>
                        <p class="half animated anim_y">
                            <label for="phone_number">Broj Telefona</label>
                            <input type="text" name="phone_number" id="phone_number" class="<?php echo $registration_errors->get_error_message('phone_number') ? 'error-field' : ''; ?>" value="<?php echo $phone_number; ?>" required>
                            <?php if ($registration_errors->get_error_message('phone_number')): ?>
                                <span class="error-message"><?php echo $registration_errors->get_error_message('phone_number'); ?></span>
                            <?php endif; ?>
                        </p>
                        <p class="half animated anim_y">
                            <label for="subscribe_level">Nivo pretplate*</label>
                            <select name="subscribe_level" id="subscribe_level" class="<?php echo $registration_errors->get_error_message('subscribe_level') ? 'error-field' : ''; ?>" required>
                                <option value="lvl1" <?php selected($subscribe_level, 'lvl1'); ?>>Level 1</option>
                                <option value="lvl2" <?php selected($subscribe_level, 'lvl2'); ?>>Level 2</option>
                                <option value="lvl3" <?php selected($subscribe_level, 'lvl3'); ?>>Level 3</option>
                            </select>
                            <?php if ($registration_errors->get_error_message('subscribe_level')): ?>
                                <span class="error-message"><?php echo $registration_errors->get_error_message('subscribe_level'); ?></span>
                            <?php endif; ?>
                        </p>
                        <p class="btn-holder animated anim_y">
                            <input class="btn" type="submit" name="submit" value="Registruj se">
                        </p>
        
                        <p class="additional-text animated anim_y">* Obavezna polja</p>
        
                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}