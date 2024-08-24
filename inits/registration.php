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

                // Send registration confirmation email to the user
                $s_e_to = $email;
                $s_e_subject = 'In Memoriam - Uspešna registracija';
                $s_e_message = "<h1>Poštovani/a, " . $first_name . " " . $last_name . "</h1>";
                $s_e_message .= "<p>Uspešno ste se registrovali na našem sajtu. Vaši podaci su:</p>";
                $s_e_message .= "<p>Username: " . $username . "</p>";
                $s_e_message .= "<p>Email: " . $email . "</p>";
                $s_e_message .= "<p>Šifra: vaša odabrana.</p>";
                $s_e_message .= "<p>Nivo pretplate: " . $subscribe_level . "</p>";
                $s_e_message .= "<br><p>Stupićemo u kontakt sa Vama putem telefona ili email-a što pre možemo.</p>";
                $s_e_message .= "<br><p>Hvala Vam na poverenju.</p>";
                $s_e_headers = array('Content-Type: text/html; charset=UTF-8');

                if ( wp_mail($s_e_to, $s_e_subject, $s_e_message, $s_e_headers) ) {
                    // Generate and send payment instructions after the first email
                    $payment_instructions = generate_payment_instructions($username, $subscribe_level, $first_name, $last_name);

                    $p_i_subject = 'In Memoriam - Uputstvo za plaćanje';
                    $p_i_message = $payment_instructions;

                    wp_mail($s_e_to, $p_i_subject, $p_i_message, $s_e_headers);

                    notify_admin_new_user_registration($user_id, $username, $first_name, $last_name, $subscribe_level, $phone_number);

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

add_shortcode('custom_login_form', 'custom_registration_form_shortcode');
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

// EMAILS

// Poruka koja se salje sa instrukcijama za placanje
function generate_payment_instructions($username, $subscribe_level, $first_name, $last_name) {
    $price = 0;

    // Determine the price based on the subscription level
    switch ($subscribe_level) {
        case 'lvl1':
            $price = 100;
            break;
        case 'lvl2':
            $price = 200;
            break;
        case 'lvl3':
            $price = 300;
            break;
        default:
            $price = 0;
            break;
    }

    // Create the payment instructions text with a styled HTML table
    $instructions = "
    <h1 style='font-family: Arial, sans-serif; color: #333;'>Poštovani, {$first_name} {$last_name}</h1>
    <p style='font-family: Arial, sans-serif; color: #555;'>Hvala Vam na registraciji, {$username}. U nastavku su uputstva za uplatu:</p>
    <table style='width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; color: #333;'>
        <tr>
            <th style='border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;'>Primalac</th>
            <th style='border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;'>Račun</th>
            <th style='border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;'>Uplatilac</th>
            <th style='border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;'>Cena</th>
        </tr>
        <tr>
            <td style='border: 1px solid #ddd; padding: 8px;'>XMY</td>
            <td style='border: 1px solid #ddd; padding: 8px;'>xxx-xxxxxxx-xxx</td>
            <td style='border: 1px solid #ddd; padding: 8px;'>{$username}</td>
            <td style='border: 1px solid #ddd; padding: 8px;'>\${$price}</td>
        </tr>
    </table>
    <br>
    <p style='font-family: Arial, sans-serif; color: #555;'>Molimo Vas da izvršite uplatu kako biste završili proces registracije. Ukoliko imate bilo kakvih pitanja, slobodno nas kontaktirajte.</p>
    <br>
    <p style='font-family: Arial, sans-serif; color: #555;'>Srdačan pozdrav,</p>
    <p style='font-family: Arial, sans-serif; color: #555;'>In Memoriam tim</p>";

    return $instructions;
}

function notify_admin_new_user_registration($user_id, $username, $first_name, $last_name, $subscribe_level, $phone_number) {
    // Admin email
    $admin_email = get_option('admin_email');
    
    // Email subject
    $subject = 'Nova registracija korisnika';
    
    // Email message
    $message = "
    <h1>Detalji nove registracije korisnika</h1>
    <table style='width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; color: #333;'>
        <tr>
            <th style='border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;'>Polje</th>
            <th style='border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;'>Detalji</th>
        </tr>
        <tr>
            <td style='border: 1px solid #ddd; padding: 8px;'>Korisničko ime</td>
            <td style='border: 1px solid #ddd; padding: 8px;'>{$username}</td>
        </tr>
        <tr>
            <td style='border: 1px solid #ddd; padding: 8px;'>Ime</td>
            <td style='border: 1px solid #ddd; padding: 8px;'>{$first_name}</td>
        </tr>
        <tr>
            <td style='border: 1px solid #ddd; padding: 8px;'>Prezime</td>
            <td style='border: 1px solid #ddd; padding: 8px;'>{$last_name}</td>
        </tr>
        <tr>
            <td style='border: 1px solid #ddd; padding: 8px;'>Nivo pretplate</td>
            <td style='border: 1px solid #ddd; padding: 8px;'>{$subscribe_level}</td>
        </tr>
        <tr>
            <td style='border: 1px solid #ddd; padding: 8px;'>Broj telefona</td>
            <td style='border: 1px solid #ddd; padding: 8px;'>{$phone_number}</td>
        </tr>
    </table>
    <br>
    <p style='font-family: Arial, sans-serif; color: #555;'>Novi korisnik se registrovao na vašem sajtu. Molimo vas da pregledate njihove podatke iznad.</p>
    ";
    
    // Email headers
    $headers = array('Content-Type: text/html; charset=UTF-8');
    
    // Send email
    wp_mail($admin_email, $subject, $message, $headers);
}

function notify_admin_and_user_on_memorial_post($post_id, $post, $update) {
    // Only run on the 'memorials' CPT and only when creating a new post, not updating
    if ($post->post_type != 'memorials' || $update) {
        return;
    }

    // Get post author info
    $user_id = $post->post_author;
    $user_info = get_userdata($user_id);
    $username = $user_info->user_login;
    
    // Prepare data for the email
    $post_name = $post->post_title;
    $post_link = get_permalink($post_id);
    $backend_link = admin_url('post.php?post=' . $post_id . '&action=edit');
    
    // Admin email notification
    $admin_email = get_option('admin_email');
    $admin_subject = 'Novi memorijalni post je kreiran';
    $admin_message = "
    <h1>Detalji o novom memorijalnom postu</h1>
    <table style='width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; color: #333;'>
        <tr>
            <th style='border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;'>Polje</th>
            <th style='border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;'>Detalji</th>
        </tr>
        <tr>
            <td style='border: 1px solid #ddd; padding: 8px;'>Korisnički ID</td>
            <td style='border: 1px solid #ddd; padding: 8px;'>{$user_id}</td>
        </tr>
        <tr>
            <td style='border: 1px solid #ddd; padding: 8px;'>Korisničko ime</td>
            <td style='border: 1px solid #ddd; padding: 8px;'>{$username}</td>
        </tr>
        <tr>
            <td style='border: 1px solid #ddd; padding: 8px;'>Link do posta</td>
            <td style='border: 1px solid #ddd; padding: 8px;'><a href='{$post_link}'>{$post_link}</a></td>
        </tr>
        <tr>
            <td style='border: 1px solid #ddd; padding: 8px;'>Backend link</td>
            <td style='border: 1px solid #ddd; padding: 8px;'><a href='{$backend_link}'>{$backend_link}</a></td>
        </tr>
    </table>
    <br>
    <p style='font-family: Arial, sans-serif; color: #555;'>Novi memorijalni post je kreiran od strane korisnika. Molimo vas da pregledate post i odobrite ga po potrebi.</p>
    ";
    $headers = array('Content-Type: text/html; charset=UTF-8');
    wp_mail($admin_email, $admin_subject, $admin_message, $headers);
    
    // User email notification
    $user_email = $user_info->user_email;
    $user_subject = 'Vaš memorijalni post je na pregledu';
    $user_message = "
    <h1>Poštovani, {$username}</h1>
    <p>Vaš memorijalni post je uspešno kreiran i trenutno se nalazi na pregledu.</p>
    <p>Bićete obavešteni putem emaila kada post bude odobren i objavljen.</p>
    <br>
    <p style='font-family: Arial, sans-serif; color: #555;'>Hvala vam na poverenju.</p>
    ";
    wp_mail($user_email, $user_subject, $user_message, $headers);
}

// Hook into the save_post action
add_action('save_post', 'notify_admin_and_user_on_memorial_post', 10, 3);
