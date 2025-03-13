<?php

// Ensure the user is logged in
if (!is_user_logged_in()) {
    wp_redirect(home_url('/login/'));
    exit;
}

$current_user = wp_get_current_user();
$is_admin = current_user_can('administrator');
$author_id = get_query_var('author');
$is_own_profile = ($current_user->ID == $author_id);

if (!$is_admin && !$is_own_profile) {
    wp_redirect(home_url());
    exit;
}

$author = get_userdata($author_id);
?>

<?php get_header(); ?>

<section class="title_text mt-100">
    <div class="wrapper">
        <div class="holder">
            <article class="animated anim_y in_view">
                <h1>Ovo je vaš profil "<?php echo esc_html($author->display_name); ?>"</h1>
            </article>
        </div>
    </div>
</section>

<section class="author-profile">
    <div class="wrapper">
        <div class="holder">
            <div class="author-info">

                <?php if ($is_own_profile || $is_admin): ?>
                    <?php
                    // Process form submission for profile update
                    if ('POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST['update_profile'])) {
                        $first_name = sanitize_text_field($_POST['first_name']);
                        $last_name = sanitize_text_field($_POST['last_name']);
                        $email = sanitize_email($_POST['email']);
                        $phone_number = sanitize_text_field($_POST['phone_number']);
                        $new_password = sanitize_text_field($_POST['new_password']);
                        $confirm_password = sanitize_text_field($_POST['confirm_password']);

                        // Update user basic info
                        wp_update_user([
                            'ID' => $author_id,
                            'first_name' => $first_name,
                            'last_name' => $last_name,
                            'user_email' => $email,
                        ]);

                        update_user_meta($author_id, 'phone_number', $phone_number);

                        // Update password if provided and matches confirmation
                        if (!empty($new_password) && $new_password === $confirm_password) {
                            wp_set_password($new_password, $author_id);
                            echo '<div class="success-message">Password successfully updated.</div>';
                        } elseif (!empty($new_password) && $new_password !== $confirm_password) {
                            echo '<div class="error-message">Passwords do not match. Please try again.</div>';
                        }

                        echo '<div class="success-message">Profil uspesno updatovan.</div>';
                    }

                    // Fetch current profile data
                    $first_name = get_user_meta($author_id, 'first_name', true);
                    $last_name = get_user_meta($author_id, 'last_name', true);
                    $email = $author->user_email;
                    $phone_number = get_user_meta($author_id, 'phone_number', true);
                    ?>
                    <div class="author-form custom-forms">
                        <form id="update-profile-form" action="" method="post">
                            <input type="hidden" name="update_profile" value="1">
    
                            <p class="half animated anim_y">
                                <label for="first_name">Ime*</label>
                                <input type="text" name="first_name" id="first_name" value="<?php echo esc_attr($first_name); ?>" required>
                            </p>
                            <p class="half animated anim_y">
                                <label for="last_name">Prezime*</label>
                                <input type="text" name="last_name" id="last_name" value="<?php echo esc_attr($last_name); ?>" required>
                            </p>
                            <p class="half animated anim_y">
                                <label for="email">Email*</label>
                                <input type="email" name="email" id="email" value="<?php echo esc_attr($email); ?>" required>
                            </p>
                            <p class="half animated anim_y">
                                <label for="phone_number">Broj Telefona</label>
                                <input type="text" name="phone_number" id="phone_number" value="<?php echo esc_attr($phone_number); ?>" required>
                            </p>
                            <p class="half animated anim_y">
                                <label for="new_password">Nova Lozinka</label>
                                <input type="password" name="new_password" id="new_password">
                                <span class="toggle-password" toggle="#new_password">
                                    <svg width="800px" height="800px" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16 16H13L10.8368 13.3376C9.96488 13.7682 8.99592 14 8 14C6.09909 14 4.29638 13.1557 3.07945 11.6953L0 8L3.07945 4.30466C3.14989 4.22013 3.22229 4.13767 3.29656 4.05731L0 0H3L16 16ZM5.35254 6.58774C5.12755 7.00862 5 7.48941 5 8C5 9.65685 6.34315 11 8 11C8.29178 11 8.57383 10.9583 8.84053 10.8807L5.35254 6.58774Z" fill="#000000"/>
                                        <path d="M16 8L14.2278 10.1266L7.63351 2.01048C7.75518 2.00351 7.87739 2 8 2C9.90091 2 11.7036 2.84434 12.9206 4.30466L16 8Z" fill="#000000"/>
                                    </svg>
                                </span>
                            </p>
                            <p class="half animated anim_y">
                                <label for="confirm_password">Potvrdite Novu Lozinku</label>
                                <input type="password" name="confirm_password" id="confirm_password">
                                <span class="toggle-password" toggle="#confirm_password">
                                    <svg width="800px" height="800px" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16 16H13L10.8368 13.3376C9.96488 13.7682 8.99592 14 8 14C6.09909 14 4.29638 13.1557 3.07945 11.6953L0 8L3.07945 4.30466C3.14989 4.22013 3.22229 4.13767 3.29656 4.05731L0 0H3L16 16ZM5.35254 6.58774C5.12755 7.00862 5 7.48941 5 8C5 9.65685 6.34315 11 8 11C8.29178 11 8.57383 10.9583 8.84053 10.8807L5.35254 6.58774Z" fill="#000000"/>
                                        <path d="M16 8L14.2278 10.1266L7.63351 2.01048C7.75518 2.00351 7.87739 2 8 2C9.90091 2 11.7036 2.84434 12.9206 4.30466L16 8Z" fill="#000000"/>
                                    </svg>
                                </span>
                            </p>
                            <p class="btn-holder animated anim_y">
                                <input class="btn" type="submit" name="submit" value="Izmenite Profil">
                                <a href="<?php echo site_url(); ?>/wp-admin/edit.php?post_type=memorials" class="btn kreiraj">Kreiraj spomen stranu</a>
                            </p>
                        </form>
                    </div>
                <?php else: ?>
                    <p><strong>Ime:</strong> <?php echo esc_html($first_name); ?></p>
                    <p><strong>Prezime:</strong> <?php echo esc_html($last_name); ?></p>
                    <p><strong>Email:</strong> <?php echo esc_html($email); ?></p>
                    <p><strong>Broj Telefona:</strong> <?php echo esc_html($phone_number); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
