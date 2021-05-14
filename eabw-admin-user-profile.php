<?php

function eabw_social_links_form(WP_User $user) {
    ?>
    <h2>Easy Author Box Widget</h2>
    <table class="form-table" role="presentation">
        <tbody>
            <tr>
                <th><label for="eabw-user-social">Social Links</label></th>
                <td>
                    <table class="form-table eabw-social-table" id="eabw-profile-social-links">
                        <tbody>
                            <tr>
                                <th class="eabw-social-icon">Icon</th>
                                <th class="eabw-social-service">Service</th>
                                <th class="eabw-social-link">Link</th>
                                <th class="eabw-social-delete">Delete</th>
                            </tr>
                            <?php
                                $data = get_user_meta($user->ID, "eabw_social_links", true);
                                foreach($data as $linkdata) { ?>
                                    <tr>
                                        <td class="eabw-social-icon">
                                            <?php if($linkdata[1] != 'other') { ?>
                                                <input type="text" name="eabw-txtIcon[]" value="<?php echo($linkdata[0]); ?>" hidden>
                                                <i class="fab fa-<?php echo($linkdata[0]); ?> color"></i>
                                            <?php } else { ?>
                                                <input type="text" name="eabw-txtIcon[]" value="<?php echo($linkdata[0]); ?>">
                                            <?php } ?>
                                        </td>
                                        <td class="eabw-social-service">
                                            <input type="text" name="eabw-txtCustom[]" value="<?php echo($linkdata[1]); ?>" hidden>
                                            <?php if($linkdata[1] != 'other') { ?>
                                                <input type="text" name="eabw-txtService[]" value="<?php echo($linkdata[2]); ?>" hidden>
                                                <?php echo($linkdata[2]); ?>
                                            <?php } else { ?>
                                                <input type="text" name="eabw-txtService[]" value="<?php echo($linkdata[2]); ?>">
                                            <?php } ?>
                                        </td>
                                        <td class="eabw-social-link">
                                            <input type="text" name="eabw-txtLink[]" value="<?php echo($linkdata[3]); ?>">
                                        </td>
                                        <td class="eabw-social-delete">
                                            <div onclick="deleteRow(this)"><i class="fa fa-trash-alt color"></i></div>
                                        </td>
                                    </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <select id="eabw-profile-social-options">
                        <option>Facebook</option>
                        <option>GitHub</option>
                        <option>Instagram</option>
                        <option>LinkedIn</option>
                        <option>Pinterest</option>
                        <option>Reddit</option>
                        <option>Snapchat</option>
                        <option>Twitter</option>
                        <option>YouTube</option>
                        <option disabled style="font-size: 1px; background: #000000;">&nbsp;</option>
                        <option value="other">Other...</option>
                    </select>
                    <button type="button" onclick="addRow('eabw-profile-social-links', 'eabw-profile-social-options')">Add Link</button>
                </td>
            </tr>
        </tbody>
    </table>
    <?php
}
add_action('show_user_profile', 'eabw_social_links_form'); // editing your own profile
add_action('edit_user_profile', 'eabw_social_links_form'); // editing another user
add_action('user_new_form', 'eabw_social_links_form'); // creating a new user

function eabw_social_links_save($userId) {
    if (!current_user_can('edit_user', $userId)) {
        return;
    }

    $icons = $_POST['eabw-txtIcon'];
    $customs = $_POST['eabw-txtCustom'];
    $services = $_POST['eabw-txtService'];
    $links = $_POST['eabw-txtLink'];

    $data = array_map(null, $icons, $customs, $services, $links);

    update_user_meta( $userId, 'eabw_social_links', $data);
}
add_action('personal_options_update', 'eabw_social_links_save');
add_action('edit_user_profile_update', 'eabw_social_links_save');
add_action('user_register', 'eabw_social_links_save');

?>