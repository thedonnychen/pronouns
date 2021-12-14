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
        add_filter('the_author', [$this, 'addPronounsToAuthor']);
        add_filter('comment_author', [$this, 'addPronounsToAuthor']); // different themes use comment_author or get_comment_author
        add_filter('get_comment_author', [$this, 'addPronounsToAuthor']);
    }
    
    /**
     * Adds pronoun field to user field
     * @return bool
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

        return;
    }

    /**
     * Saves pronoun field
     * @return bool
     */
    public function saveProfileFields($user_id)
    {
        if (!current_user_can('edit_user', $user_id)) {
            return false;
        }
        
        update_usermeta( $user_id, 'pronouns', $_POST['pronouns'] );

        return true;
    }

    /**
     * Changes Author and Comment names to include pronouns
     * Changed on string level because each theme's comment/author theme files are different, to fit most use cases.
     * @return string
     */
    public function addPronounsToAuthor($author)
    {
        // If field doesn't exist, keep default
        if (!get_the_author_meta('pronouns')) {
            return $author;
        }

        // Accounts for Post Author
        if (!get_comment()) {
            $author = $author . ' (' . get_the_author_meta('pronouns') . ')';
            return $author;
        }

        // Accounts for Post Comment
        $author = $author . ' (' . get_the_author_meta('pronouns', get_comment()->user_id) . ')';

        return $author;
    }
}