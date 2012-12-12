<?php

//設定の初期化：はじめて有効化したときだけ処理を行う
function simple_clock_init_option() {
    if(!get_option('clock_installed')) {
        update_option('font_size', 15);
        update_option('clock_style', 'a');
        update_option('clock_installed', 1);
    }
}
register_activation_hook('/wordpress/wp-content/plugins/Clock/Clock.php', 'simple_clock_init_option');

//管理画面への設定ページの設置
function simple_clock_add_admin_menu() {
    add_submenu_page('options-general.php','Simple Clockの設定','Simple Clockの設定',8,'/wordpress/wp-content/plugins/Clock/Clock.php','simple_clock_admin_page');
}
add_action('admin_menu','simple_clock_add_admin_menu');

function simple_clock_admin_page() {

    if ($_POST['posted']=='Y') {
        update_option('font_size', intval($_POST['font_size']));
        update_option('clock_style', stripcslashes($_POST['clock_style']));
    }
    ?>
    <?php if ($_POST['posted']=='Y'): ?>
    <div class="updated">
        <p><strong>設定を保存しました</strong></p>
    </div><?php endif; ?>

    <div class="wrap">
        <h2>Simple Clock 詳細設定</h2>
        <form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
            <?php wp_nonce_field('update-options'); ?>
            <input type="hidden" name="posted" value="Y">
            <table class="clock_table">
                <tbody>
                    <tr valign="top">
                        <th scope="row">
                            <label for="font_size">フォントサイズ</label>
                        </th>
                        <td>
                            <p><input name="font_size" type="text" id="font_size" value="<?php echo get_option('font_size');?>" class="regular-text code" /><br/>
                            半角数字を入力してください
                            </p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="日付表示様式">日付表示様式</label>
                        </th>
                        <td>
                            <p><input name="clock_style" type="radio" class="clock_style" value="a" <?php if (get_option('clock_style')=="a"): ?>checked="checked"<?php endif; ?> class="regular-text code" />Year年Month月Day日（Week）Hours時Minutes分Seconds秒<br/>例）　2012年12月12日（水）12時12分12秒</p>
                            <p><input name="clock_style" type="radio" class="clock_style" value="b" <?php if (get_option('clock_style')=="b"): ?>checked="checked"<?php endif; ?> class="regular-text code" />Year.Month.Day.（Week）Hours:Minuts:Seconds<br/>例）　2012.12.12.（Wed）12:12:12</p>
                            <p><input name="clock_style" type="radio" class="clock_style" value="c" <?php if (get_option('clock_style')=="c"): ?>checked="checked"<?php endif; ?> class="regular-text code" />Hours:Minutes:Seconds<br/>例）　12:12:12 （時刻のみ表示）</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p class="submit">
                <input type="submit" name="submit" class="button-primary" value="変更を保存" />
            </p>
        </form>

    </div>
<?php
}
?>