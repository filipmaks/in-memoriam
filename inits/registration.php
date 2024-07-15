<?php
// Start output buffering
ob_start();

// Add action for custom user registration
add_action('init', 'custom_user_registration');

function custom_user_registration() {
    if ('POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST['submit']) && isset($_POST['registration_form'])) {
        $username = sanitize_user($_POST['username']);
        $email = sanitize_email($_POST['email']);
        $password = $_POST['password'];
        $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
        $phone_number = isset($_POST['phone_number']) ? sanitize_text_field($_POST['phone_number']) : '';
        $subscribe_level = isset($_POST['subscribe_level']) ? sanitize_text_field($_POST['subscribe_level']) : '';

        $errors = new WP_Error();

        // Validate username
        if (empty($username) || !validate_username($username) || username_exists($username)) {
            $errors->add('username', 'Invalid or already taken username.');
        }

        // Validate email
        if (empty($email) || !is_email($email) || email_exists($email)) {
            $errors->add('email', 'Invalid or already taken email.');
        }

        // Validate password
        if (empty($password) || $password !== $confirm_password) {
            $errors->add('password', 'Passwords do not match.');
        }

        if (empty($phone_number)) {
            $errors->add('phone_number', 'Phone number is required.');
        }

        if (empty($subscribe_level)) {
            $errors->add('subscribe_level', 'Subscribe level is required.');
        }

        if (empty($errors->errors)) {
            // Create user
            $user_id = wp_create_user($username, $password, $email);

            if (!is_wp_error($user_id)) {
                // Update ACF fields
                update_field('phone_number', $phone_number, 'user_' . $user_id);
                update_field('subscribe_level', $subscribe_level, 'user_' . $user_id);

                // Redirect to success page
                wp_redirect(home_url('/uspesna-registracija/'));
                exit;
            } else {
                $error_message = $user_id->get_error_message();
            }
        } else {
            $error_message = '';
            foreach ($errors->errors as $error) {
                $error_message .= $error[0] . '<br>';
            }
        }

        if (isset($error_message)) {
            echo '<div class="error-message">' . $error_message . '</div>';
        }
    }
}

// Add the shortcode to display the custom registration form
add_shortcode('custom_registration_form', 'custom_registration_form_shortcode');

function custom_registration_form_shortcode() {
    ob_start();
    ?>
    <div class="registration-form">
        <form id="custom-registration-form" action="" method="post">
            <input type="hidden" name="registration_form" value="1">
            <p>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>
            </p>
            <p>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </p>
            <p>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </p>
            <p>
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" required>
            </p>
            <p>
                <label for="phone_number">Phone Number</label>
                <input type="text" name="phone_number" id="phone_number" required>
            </p>
            <p>
                <label for="subscribe_level">Subscribe Level</label>
                <select name="subscribe_level" id="subscribe_level" required>
                    <option value="lvl1">Level 1</option>
                    <option value="lvl2">Level 2</option>
                    <option value="lvl3">Level 3</option>
                </select>
            </p>
            <p>
                <input type="submit" name="submit" value="Register">
            </p>
        </form>
        <?php custom_user_registration(); ?>
    </div>
    <?php
    return ob_get_clean();
}

// Add action for custom user login
add_action('init', 'custom_user_login');

function custom_user_login() {
    if ('POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST['submit']) && isset($_POST['login_form'])) {
        $username = sanitize_user($_POST['username']);
        $password = $_POST['password'];

        $credentials = array(
            'user_login'    => $username,
            'user_password' => $password,
            'remember'      => true,
        );

        $user = wp_signon($credentials, false);

        if (is_wp_error($user)) {
            $error_message = $user->get_error_message();
        } else {
            // Redirect to homepage
            wp_redirect(home_url());
            exit;
        }

        if (isset($error_message)) {
            echo '<div class="error-message">' . $error_message . '</div>';
        }
    }
}

// Add the shortcode to display the custom login form
add_shortcode('custom_login_form', 'custom_login_form_shortcode');

function custom_login_form_shortcode() {
    ob_start();
    ?>
    <div class="login-form">
        <form id="custom-login-form" action="" method="post">
            <input type="hidden" name="login_form" value="1">
            <p>
                <label for="username">Username or Email</label>
                <input type="text" name="username" id="username" required>
            </p>
            <p>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </p>
            <p>
                <input type="submit" name="submit" value="Login">
            </p>
        </form>
        <?php custom_user_login(); ?>
    </div>
    <?php
    return ob_get_clean();
}
?>
