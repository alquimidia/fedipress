<?php
/**
 * This template shows the Friends list.
 *
 * @version 1.0
 * @package Friends
 */
?>

<?php 
$query = Friends\User_Query::all_associated_users();
$friends = $query->get_results();?>
<div class="following col-12">
    <?php if ( empty( $friends ) ) : ?>
        <p><?php esc_html_e( "You don't have any friends or subscriptions yet.", 'friends' ); ?></a></p>
    <?php else : ?>
        <div class="add-friend col-12">
            <a class="btn btn-primary" href="<?php echo esc_url( self_admin_url( 'admin.php?page=add-friend' ) ); ?>">
                <?php esc_html_e( 'Add New Friend', 'friends' ); ?>
            </a>
        </div>
    <?php
    foreach ( $friends as $friend_user ) : ?>
            <div class="description columns col-12" >
                <div class="col-2">
                    <?php echo wp_kses(
                        get_avatar( $friend_user->user_login, 32 ),
                        array(
                            'img' => array(
                                'src'    => array(),
                                'alt'    => array(),
                                'class'  => array(),
                                'width'  => array(),
                                'height' => array(),
                            ),
                        )
                    );?>
                    <a href="<?php echo esc_url( Friends\Admin::admin_edit_user_link( false, $friend_user ) ); ?>">
                        <?php echo esc_html( $friend_user->display_name ); ?>
                    </a>
                </div>
                <div class="col-3">
                    <a href="<?php echo esc_url( $friend_user->user_url ); ?>">
                        <?php echo "URL <br>" . esc_html( wp_parse_url( $friend_user->user_url, PHP_URL_HOST ) ); ?>
                    </a>
                </div>
                <div class="col-3">
                    <?php esc_html_e( "Since", 'friends' );
                        echo "<br>" . esc_html( date_i18n( __( 'F j, Y g:i a' ), strtotime( $friend_user->user_registered ) ) );
                    ?>
                </div>
                <div class="col-2">
                    <?php echo "Status <br>" . esc_html( $friend_user->get_role_name() ); ?>
                </div>
                <div class="col-1">
                    <?php if ( $friend_user instanceof Friends\Subscription ) : ?>
                        <?php esc_html_e( 'Virtual User', 'friends' ); ?>
                        <?php if ( apply_filters( 'friends_debug', false ) ) : ?>
                            <span class="info">ID: <?php echo esc_html( $friend_user->get_term_id() ); ?></span>
                        <?php endif; ?>
                    <?php else : ?>
                        <?php esc_html_e( 'User', 'friends' ); ?>
                        <?php if ( apply_filters( 'friends_debug', false ) ) : ?>
                            <span class="info">ID: <?php echo esc_html( $friend_user->ID ); ?></span>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <div class="col-1">
                    <?php echo "Posts <br>" . wp_kses_post( Friends\Admin::user_list_custom_column( '', 'friends_posts', $friend_user->ID ) ); ?>
                </div>
            </div>
            <div class="edition col-12">
                <?php
                $actions = array(
                    'edit' => sprintf(
                        '<a href="%s">%s</a>',
                        esc_url( Friends\Admin::admin_edit_user_link( false, $friend_user ) ),
                        esc_html__( 'Edit', 'friends' )
                    ),
                );

                if ( $friend_user->has_cap( 'friend_request' ) ) {
                    $actions['unfriend'] = sprintf(
                        '<a href="%s">%s</a>',
                        esc_url( Friends\Admin::get_unfriend_link( $friend_user ) ),
                        esc_html__( 'Delete', 'friends' )
                    );
                } else {
                    $actions['unfriend'] = sprintf(
                        '<a href="%s">%s</a>',
                        esc_url( Friends\Admin::get_unfriend_link( $friend_user ) ),
                        esc_html__( 'Unfriend', 'friends' )
                    );
                }

                $sep = '';
                foreach ( Friends\Admin::user_row_actions( $actions, $friend_user ) as $key => $_action ) {
                    echo esc_html( $sep );
                    $sep = ' | ';
                    ?>
                <span class="<?php echo esc_attr( $key ); ?>">
                    <?php
                    echo wp_kses_post( $_action );
                    ?>
                </span>
                <?php } ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>