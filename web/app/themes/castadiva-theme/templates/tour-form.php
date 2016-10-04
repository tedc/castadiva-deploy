<?php use Roots\Sage\Extras; 

if($_POST) : 
	if(isset($_POST['email'])) $email = $_POST['email'];
//	if(isset($_POST['sender'])) $sender = $_POST['sender'];
//	if(isset($_POST['message'])) $message = $_POST['message'];
//	if(isset($_POST['subject'])) $subject = $_POST['subject'];
//	$tel = (isset($_POST['tel'])) ? '<tr style="border-bottom: 1px solid #e1e1e1;"><td style="text-align:center;padding:20px;"><em style="color:#FAD755;font-size:12px;font-style:italic">Telefono</em><br />'.$_POST['tel'].'</td></tr>' : "";
    $pTo = array(get_option('tour_settings')['email']);
    $pSubject = 'Richiesta informazioni per un itinerario';
//if(empty($_POST['sender'])) $fields_not_set[] = "sender";
//if(empty($_POST['email'])) $fields_not_set[] = "email";
//if(empty($_POST['message'])) $fields_not_set[] = "message";
//if(empty($_POST['subject'])) $fields_not_set[] = "subject";
$first_row = (!empty($_POST['email'])) ? '<tr style="border-bottom: 1px solid #e1e1e1;"><td style="text-align:center;padding:20px;"><em style="color:#FAD755;font-size:12px;font-style:italic">Da</em><br /><a href="mailto:'.$email.'" style="text-decoration:none;font-weight:bold;color:#00A1B0">'.$email.'</a></td></tr>' : "";
$body = $first_row;
$body .= '<tr style="border-bottom: 1px solid #e1e1e1;"><td style="text-align:center;padding:20px;">Salve, mi interesserebbe ricevere informazioni relative all\'itinerario<br/><a href="'.get_the_permalink(get_the_ID()).'" style="text-decoration:none;font-weight:bold;color:#00A1B0">'.get_the_title(get_the_ID()).'</a>.<br/><br/>Grazie mille, cordiali saluti.</td></tr>';
//$body = $first_row.'<tr style="border-bottom: 1px solid #e1e1e1"><td style="text-align:center;padding:20px;"><em style="color:#FAD755;font-size:14px;font-style:italic">Email</em><br /><a href="mailto:'.$email.'" style="text-decoration:none;font-weight:bold;color:#00A1B0">'.$email.'</a></td></tr>'.$tel.'<tr style="border-bottom: 1px solid #e1e1e1"><td style="padding:20px;text-align:center"><em style="color:#FAD755;font-size:12px;font-style:italic">Messaggio</em><p style="padding:0;margin:0;line-height:1.2;text-align:left"><br />'.$message.'</p></td></tr>';
    
function template($body) {
    $html = '<html><head><meta charset="utf-8" /></head><body style="background-color:#fff"><div style="background-color:#fff;font-family:\'Helvetica Neue\', Helvetica, Arial, san-serif;font-size:18px;color:#464646;max-width:500px;margin:0 auto;"><table style="width:100%;border-collapse:collapse;"><thead><tr><td style="padding: 20px;text-align:center; background-color:#fff"><a href="'.get_bloginfo('url').'" style="text-decoration:none"><img src="'.get_stylesheet_directory_uri().'/assets/img/logo-mail.jpg" style="border:0;width:100%;max-width:200px;height:auto"/></a></td></tr></thead><tfoot><tr><td style="padding:20px; text-align:center;color:#FAD755;font-size:11px">'.get_field('testo', 'options').'<br /><a href="'.get_bloginfo('url').'" style="text-decoration:none;font-weight:bold;color:#00A1B0">'.str_replace('http://', '', get_bloginfo('url')).'</a></td></tr></tfoot><tbody>'.$body.'</tbody></table></div></body></html>';
    return $html;
}if(empty($fields_not_set)) {
        $transport = Swift_MailTransport::newInstance();
        $logger = new \Swift_Plugins_Loggers_EchoLogger();
        $transport->registerPlugin(new \Swift_Plugins_LoggerPlugin($logger));
        $mMailer = Swift_Mailer::newInstance($transport);
        $mEmail = Swift_Message::newInstance();
        $mEmail->setSubject($pSubject);
        $mEmail->setTo($pTo);
        //$mEmail->setBcc(array('e.grandinetti@bspkn.it','a.trussardi@bspkn.it', 'a.mangilli@bspkn.it', 'a.biffi@bspkn.it'));
        $mEmail->setFrom(array($email => 'Visitatore del sito Castadiva'));
        $mEmail->setReplyTo(array($email));
        $mEmail->setBody(template($body), 'text/html');  
        if( $mMailer->send($mEmail)){
            echo "sent";
        } else {
            echo $logger->dump();
        }
    }
endif;
?> 
<header class="container aligncenter row-btm row-lg-btm">
    <h4 class="title main-title">
        <?php echo __('Richiedi<strong>Informazioni</strong>', 'castadiva'); ?>
</header>
<form novalidate ng-submit="onSubmit(contactForm.$valid, '<?php the_permalink(); ?>')" casta-form name="contactForm" >
    <div class="form-container">
        <input type="email" name="email" ng-model="formData.email" placeholder="<?php echo __('Inserisci il tuo indirizzo email', 'castadiva'); ?>" required />
    </div>
    <p class="buttons">
        <?php Extras\btn($text = __('Invia', 'castadiva'), $link = null, $btn = true); ?>
    </p>
</form>