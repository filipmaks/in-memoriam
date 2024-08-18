<?php
/**
 * The template for displaying author pages.
 *
 * @package YourThemeName
 */

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
                        // $subscribe_level = sanitize_text_field($_POST['subscribe_level']);

                        wp_update_user([
                            'ID' => $author_id,
                            'first_name' => $first_name,
                            'last_name' => $last_name,
                            'user_email' => $email,
                        ]);

                        update_user_meta($author_id, 'phone_number', $phone_number);
                        // update_user_meta($author_id, 'subscribe_level', $subscribe_level);

                        echo '<div class="success-message">Profil uspesno updatovan.</div>';
                    }

                    // Fetch current profile data
                    $first_name = get_user_meta($author_id, 'first_name', true);
                    $last_name = get_user_meta($author_id, 'last_name', true);
                    $email = $author->user_email;
                    $phone_number = get_user_meta($author_id, 'phone_number', true);
                    // $subscribe_level = get_user_meta($author_id, 'subscribe_level', true);
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
                            <?php /* ?>
                            <p class="half animated anim_y">
                                <label for="subscribe_level">Nivo pretplate*</label>
                                <select name="subscribe_level" id="subscribe_level" required>
                                    <option value="lvl1" <?php selected($subscribe_level, 'lvl1'); ?>>Level 1</option>
                                    <option value="lvl2" <?php selected($subscribe_level, 'lvl2'); ?>>Level 2</option>
                                    <option value="lvl3" <?php selected($subscribe_level, 'lvl3'); ?>>Level 3</option>
                                </select>
                            </p>
                            <?php */ ?>
                            <p class="btn-holder animated anim_y">
                                <input class="btn" type="submit" name="submit" value="Izmenite Profil">
                            </p>
                        </form>
                    </div>
                <?php else: ?>
                    <p><strong>Ime:</strong> <?php echo esc_html($first_name); ?></p>
                    <p><strong>Prezime:</strong> <?php echo esc_html($last_name); ?></p>
                    <p><strong>Email:</strong> <?php echo esc_html($email); ?></p>
                    <p><strong>Broj Telefona:</strong> <?php echo esc_html($phone_number); ?></p>
                    <?php /* ?><p><strong>Nivo pretplate:</strong> <?php echo esc_html($subscribe_level); ?></p><?php */ ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
