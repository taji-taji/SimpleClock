<?php
/*
Plugin Name: Simple Clock
Author: Yutaka Tajika
Version: 1.0
*/

//SimpleClock_PLUGIN_URLをプラグインのURLと定義
define('SimpleClock_PLUGIN_URL', plugin_dir_url( __FILE__ ));

//設定ページ用外部css読み込み
add_action( 'admin_enqueue_scripts', 'simple_clock_css' );
function simple_clock_css() {
    wp_register_style('simple_clock.css', SimpleClock_PLUGIN_URL . 'simple_clock.css', array());
    wp_enqueue_style('simple_clock.css');
}

//設定ページの管理画面への出力関数を呼び出す
require('Clock_Conf.php');


//時刻取得、出力
function Simple_Clock() {

echo '
<script language="JavaScript"> 
<!--

function myTimeprev(){
	var DD　=　new Date();
	var Year = DD.getFullYear();
	var Month = DD.getMonth() + 1;
	var Day = DD.getDate();
	var Week = DD.getDay();
	var Hours = DD.getHours();
	var Minutes = DD.getMinutes();
	var Seconds = DD.getSeconds();';
    if(get_option('clock_style')=="a"){
            echo '
            var Weeks = new Array("日","月","火","水","木","金","土");
            myMsg = Year+"年"+Month+"月"+Day+"日("+Weeks[Week]+")"+Hours+"時"+Minutes+"分"+Seconds+"秒";
            ';
    }elseif(get_option('clock_style')=="b"){
            echo '
            var Weeks = new Array("Sun","Mon","Tue","Wed","Thu","Fri","Sat");
            myMsg = Year+"."+Month+"."+Day+"("+Weeks[Week]+")"+Hours+":"+Minutes+":"+Seconds;
            ';
    }elseif(get_option('clock_style')=="c"){
            echo '
            myMsg = Hours+":"+Minutes+":"+Seconds;
            ';
    }
echo 'document.getElementById("simple_clock").innerHTML = myMsg;
}
// -->
</script>
<script language="JavaScript"> 
<!--
	setInterval("myTimeprev()",1000);
// -->
</script>
<p id="simple_clock"></p>
';
}

// Now we set that function up to execute when the admin_notices action is called
add_action( 'admin_notices', 'Simple_Clock' );

// We need some CSS to position the paragraph
function clock_css() {
	// This makes sure that the positioning is also good for right-to-left languages
	$x = is_rtl() ? 'left' : 'right';

        //global $wpdb;
        //$results = $wpdb->get_results("SELECT option_value FROM $wpdb->options WHERE option_name='font_size'");
        $font = get_option('font_size');
	echo "
	<style type='text/css'>
	#simple_clock {
		float: $x;
		padding-$x: 15px;
		padding-top: 5px;		
		margin: 0;
		font-size: ".$font."px; 
	}
	</style>
	";
}

//add_action('admin_head',関数名)　で関数をヘッド部分で実行
add_action( 'admin_head', 'clock_css' );

?>