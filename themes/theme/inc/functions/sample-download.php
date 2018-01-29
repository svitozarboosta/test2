<?php
function donwlodaAndPrintLinks() {
    if (is_single() && !in_category('flashcards')) {
        if (is_user_logged_in() && pmpro_getMembershipLevelForUser()) {
            addMemBerScriptToFooter();
            global $current_user;
            $current_user->membership_level = pmpro_getMembershipLevelForUser($current_user->ID);
            if ($current_user->membership_level->name !== '') {
                $cryptor = new Cryptor();
                $crypted = $cryptor->encrypt(get_the_ID() . '-' . $current_user->user_login);
                ?>
                <a rel="nofollow" href="" data-link-id="<?= $crypted ?>" id="downLoadPost">Download this essay <img
                        class="downloadloader"
                        src="<?php echo get_template_directory_uri() ?>/assets/img/spinner.gif"></a>
                <a rel="nofollow" href="" id="printPost">Print this essay</a>
            <?php
            }
        } else {
            ?>
            <a href="/account/levels/">Download this essay</a>
            <a href="/account/levels/">Print this essay</a>
            <?php
        }
    }
}

add_action('wp_ajax_getDownloadFile', 'getDownloadFileF');
add_action('wp_ajax_nopriv_getDownloadFile', 'getDownloadFileF');

function generateDoc($root, $post, $user) {

    $phpWord = new \PhpOffice\PhpWord\PhpWord();

    $section = $phpWord->addSection();
    $fontStyleName = 'oneUserDefinedStyle';
    $depth = 'oneUserDefinedStyle';

    $phpWord->addTitleStyle(
        $depth,
        array('name' => 'Tahoma', 'size' => 16, 'color' => '3f51b5', 'bold' => true, 'lineHeight' => 1.5)
    );
    $phpWord->addFontStyle(
        $fontStyleName,
        array('name' => 'Tahoma', 'size' => 16, 'color' => '1B2232', 'bold' => false)
    );
    $phpWord->addParagraphStyle(
        $paragraphStyle,
        array('lineHeight' => 1.5)
    );

    $section->addTitle(
        htmlspecialchars($post->post_title),
        $depth
    );

    $content = $post->post_content;
    $content = strip_tags($content);

    $section->addText(
        htmlspecialchars($content, ENT_NOQUOTES),
        $fontStyleName,
        $paragraphStyle
    );


    $file = $root . '/'.$post->post_name . '_' . $user . '.docx';
    $file_url = $_SERVER['HTTP_HOST'] . '/downloads/'.$post->post_name . '_' . $user . '.docx';
    unlink($file);

    $phpWord->save($file);

    if (ob_get_level()) {
        ob_end_clean();
    }

    if (file_exists($file)) {
        $return['success'] = true;
        $return['file_url'] = $file_url;
        $return['file'] = $file;
        wp_send_json($return);
    }
}

function getDownloadFileF() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $cryptid = $_POST['postID'];
        $crypt = new Cryptor();
        $decr = $crypt->decrypt($cryptid);

        $data = explode('-', $decr);
        $id = $data[0];

        if ($id) {
            $post = get_post($id);
            $user = $data[1];

            $root = $_SERVER['DOCUMENT_ROOT'] . '/downloads';
            if (!file_exists($root)) {
                $oldumask = umask(0);
                mkdir($root, 0777, true);
                umask($oldumask);
            }
            generateDoc($root, $post, $user);
        }
    }
}

function addMemBerScriptToFooter() {
    add_action('wp_footer', function() {

        if (is_single()) :?>

            <script>
                jQuery(document).ready(function ($) {
                    $('.doDownloadLink').on('click', function (e) {
                        e.preventDefault();
                        $('#downLoadPost').click();
                    });
                    $('#downLoadPost').click(function (e) {
                        e.preventDefault();
                        id = $(this).attr('data-link-id');
                        ajaxurl = '/wp-admin/admin-ajax.php';
                        $(this).find('.downloadloader').addClass('show');

                        jQuery.ajax({
                            type: 'POST',
                            url: ajaxurl,
                            data: {
                                action: 'getDownloadFile',
                                postID: id
                            },
                            success: function(result) {
                                if (result.success) {

                                    setTimeout(function(){
                                        $a = $('<a>', {
                                            href: 'https://' + result.file_url,
                                            target: '_blank',
                                            style:'display:none',
                                            id: 'linkClick'
                                        });
                                        $(document.body).append($a);
                                        window.location.href = $('#linkClick').attr('href');
                                    }, 500);


                                    setTimeout(function(){

                                        $('#downLoadPost').find('.downloadloader').removeClass('show');
                                        ajaxurl = '/wp-admin/admin-ajax.php';
                                        jQuery.ajax({
                                            type: 'POST',
                                            url: ajaxurl,
                                            data: {
                                                action: 'getRemoveFile',
                                                url: result.file
                                            },
                                            success: function(resultDel) {
                                                if (resultDel.success) {

                                                }
                                            },
                                            error:  function(xhr, str){
                                                alert('Error: ' + xhr.responseCode);
                                            }
                                        });
                                    }, 4000);
                                }
                            },
                            error:  function(xhr, str){
                                alert('Error: ' + xhr.responseCode);
                            }
                        });
                    });
                    //print post
                    $('#printPost').click(function (e) {
                        e.preventDefault();
                        title = $('.single__title').text();
                        textClone = $('.single__text').clone();
                        textClone.find('.order').remove();
                        content = '<h1>'+title+'</h1>' + textClone.html();

                        var printWindow = window.open('','');
                        printWindow.document.write(content);

                        printWindow.document.close();
                        printWindow.focus();
                        printWindow.print();
                        printWindow.close();
                    });
                });
            </script>
            <?php
        endif;

    });
}

add_action('wp_ajax_getRemoveFile', 'getRemoveFileF');
add_action('wp_ajax_nopriv_getRemoveFile', 'getRemoveFileF');

function getRemoveFileF() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $file = $_POST['url'];
        unlink($file);
        wp_send_json(['success'=>true]);
    }
}

class Cryptor
{

    protected $method = 'AES-128-CTR'; // default
    private $key;
    private static $encryption_key = 'CKXH2U9RPY3EFD70TLS1ZG4N8WQBOVI6AMJ5';
    protected function iv_bytes()
    {
        return openssl_cipher_iv_length($this->method);
    }

    public function __construct($key = false, $method = false)
    {
        if(!$key) {
            // if you don't supply your own key, this will be the default
            $key = self::$encryption_key;
        }
        if(ctype_print($key)) {
            // convert key to binary format
            $this->key = openssl_digest($key, 'SHA256', true);
        } else {
            $this->key = $key;
        }
        if($method) {
            if(in_array($method, openssl_get_cipher_methods())) {
                $this->method = $method;
            } else {
                die(__METHOD__ . ": unrecognised encryption method: {$method}");
            }
        }
    }

    public function encrypt($data)
    {
        $iv = openssl_random_pseudo_bytes($this->iv_bytes());
        $encrypted_string = bin2hex($iv) . openssl_encrypt($data, $this->method, $this->key, 0, $iv);
        return $encrypted_string;
    }

    // decrypt encrypted string
    public function decrypt($data)
    {
        $iv_strlen = 2  * $this->iv_bytes();
        if(preg_match("/^(.{" . $iv_strlen . "})(.+)$/", $data, $regs)) {
            list(, $iv, $crypted_string) = $regs;
            $decrypted_string = openssl_decrypt($crypted_string, $this->method, $this->key, 0, hex2bin($iv));
            return $decrypted_string;
        } else {
            return false;
        }
    }

}