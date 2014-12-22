<?php
if(function_exists('sb_comments')) {
    sb_comments();
} else {
    if ( post_password_required() ) {
        return;
    }
    function sb_theme_custom_comment_nav() {
        // Are there comments to navigate through?
        if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
            ?>
            <nav class="navigation comment-navigation" role="navigation">
                <h2 class="screen-reader-text"><?php _e( 'Phân trang', 'sb-theme' ); ?></h2>
                <div class="nav-links">
                    <?php
                    if ( $prev_link = get_previous_comments_link( __( 'Bình luận cũ', 'sb-theme' ) ) ) :
                        printf( '<div class="nav-previous">%s</div>', $prev_link );
                    endif;

                    if ( $next_link = get_next_comments_link( __( 'Bình luận mới', 'sb-theme' ) ) ) :
                        printf( '<div class="nav-next">%s</div>', $next_link );
                    endif;
                    ?>
                </div><!-- .nav-links -->
            </nav><!-- .comment-navigation -->
        <?php
        endif;
    }
    ?>

    <div id="comments" class="comments-area">

        <?php if ( have_comments() ) : ?>
            <h2 class="comments-title">
                <?php
                printf( _nx( '1 bình luận cho bài viết &ldquo;%2$s&rdquo;', '%1$s bình luận cho bài viết &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'sb-theme' ),
                    number_format_i18n( get_comments_number() ), get_the_title() );
                ?>
            </h2>

            <?php sb_theme_custom_comment_nav(); ?>

            <ol class="comment-list">
                <?php
                wp_list_comments( array(
                    'style'       => 'ol',
                    'short_ping'  => true,
                    'avatar_size' => 56,
                ) );
                ?>
            </ol><!-- .comment-list -->

            <?php sb_theme_custom_comment_nav(); ?>

        <?php endif; // have_comments() ?>

        <?php
        // If comments are closed and there are comments, let's leave a little note, shall we?
        if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
            ?>
            <p class="no-comments"><?php _e( 'Bình luận đã được đóng.', 'sb-theme' ); ?></p>
        <?php endif; ?>

        <?php comment_form(); ?>

    </div><!-- .comments-area -->
    <?php
}