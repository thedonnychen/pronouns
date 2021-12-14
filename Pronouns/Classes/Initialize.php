<?php
namespace Plugins\Pronouns\Classes;

class Initialize
{
    /**
     * Actions and Filters go here
     */
    public function __construct()
    {
        add_action('show_user_profile', [$this, 'showProfileFields']);
        add_action('edit_user_profile', [$this, 'showProfileFields']);
        add_action('personal_options_update', [$this, 'saveProfileFields']);
        add_action('edit_user_profile_update', [$this, 'saveProfileFields']);
    }

    /**
     * Adds the post slug to the body class, used to style individual pages
     * @return string
     */
    public function showProfileFields($user)
    {
        ?>
        <h3>Extra profile information</h3>
        <table class="form-table">
            <tr>
                <th><label for="pronouns">Pronouns</label></th>
                <td>
                    <input type="text" name="pronouns" id="pronouns" value="<?php echo esc_attr(get_the_author_meta('pronouns', $user->ID)); ?>" class="regular-text" /><br />
                    <span class="description">Please enter your pronouns.</span>
                </td>
            </tr>
        </table>
        <?php
    }

    public function saveProfileFields($user_id)
    {
        if (!current_user_can('edit_user', $user_id)) {
            return false;
        }
        
        update_usermeta( $user_id, 'pronouns', $_POST['pronouns'] );
    }
}