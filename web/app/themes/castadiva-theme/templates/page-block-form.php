<?php
if($_POST) : 
	if(isset($_POST['email'])) $email = $_POST['email'];
	if(isset($_POST['sender'])) $sender = $_POST['sender'];
	if(isset($_POST['message'])) $message = $_POST['message'];
	if(isset($_POST['subject'])) $subject = $_POST['subject'];
	$tel = (isset($_POST['tel'])) ? '<tr style="border-bottom: 1px solid #e1e1e1;"><td style="text-align:center;padding:20px;"><em style="color:#FAD755;font-size:12px;font-style:italic">Telefono</em><br />'.$_POST['tel'].'</td></tr>' : "";
    $pTo = array(get_sub_field('email'));
    $pSubject = $subject .'. Da ' . $sender;
if(empty($_POST['sender'])) $fields_not_set[] = "sender";
if(empty($_POST['email'])) $fields_not_set[] = "email";
if(empty($_POST['message'])) $fields_not_set[] = "message";
if(empty($_POST['subject'])) $fields_not_set[] = "subject";
$first_row = (!empty($_POST['sender'])) ? '<tr style="border-bottom: 1px solid #e1e1e1;"><td style="text-align:center;padding:20px;"><em style="color:#FAD755;font-size:12px;font-style:italic">Da</em><br />'.$sender.'</td></tr>' : "";
$body = $first_row.'<tr style="border-bottom: 1px solid #e1e1e1"><td style="text-align:center;padding:20px;"><em style="color:#FAD755;font-size:14px;font-style:italic">Email</em><br /><a href="mailto:'.$email.'" style="text-decoration:none;font-weight:bold;color:#00A1B0">'.$email.'</a></td></tr>'.$tel.'<tr style="border-bottom: 1px solid #e1e1e1"><td style="padding:20px;text-align:center"><em style="color:#FAD755;font-size:12px;font-style:italic">Messaggio</em><p style="padding:0;margin:0;line-height:1.2;text-align:left"><br />'.$message.'</p></td></tr>';
    
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
        $mEmail->setFrom(array($email => $sender));
        $mEmail->setReplyTo(array($email => $sender));
        $mEmail->setBody(template($body), 'text/html');  
        if( $mMailer->send($mEmail)){
            echo "sent";
        } else {
            echo $logger->dump();
        }
    }
endif;
?>
<form novalidate ng-submit="onSubmit(contactForm.$valid, '<?php the_permalink(); ?>')" casta-form name="contactForm" ng-carousel>
    <div class="carousel-wrapper form-carousel" ng-swipe-right="dir(false, pos, 4, false, false)" ng-swipe-left="dir(true, pos, 4, steps, false)" ng-class="{'message-slide' : pos == 4}">
        <div class="carousel-item">
            <div class="form-container">
                <input type="text" placeholder="Nome e cognome (campo obbligatorio)" ng-model="formData.sender" name="sender" required ng-focus="isDisabled = contactForm.sender.$invalid" ng-blur="isDisabled = contactForm.sender.$invalid" />
            </div>
        </div>
        <div class="carousel-item">
            <div class="form-container">
                <input type="email" placeholder="Indirizzo e-mail (campo obbligatorio)" ng-model="formData.email" name="email" required ng-focus="isDisabled = contactForm.email.$invalid" ng-blur="isDisabled = contactForm.email.$invalid" />
            </div>
        </div>
        <div class="carousel-item">
            <div class="form-container">
                <input type="tel" placeholder="Telefono" ng-model="formData.phone" name="phone" />
            </div>
        </div> 
        <div class="carousel-item">
            <div class="form-container select options" ng-class="{error : (contactForm.subject.$invalid && contactForm.subject.$touched)}">
                <span class="select-text" ng-bind-html="(!contactForm.subject.$invalid) ? formData.subject : '<?php echo __('Di cosa hai bisgno? (obbligatorio)', 'castadiva'); ?>'"><?php echo __('Di cosa hai bisogno? (obbligatorio)', 'castadiva'); ?></span>
                <select ng-options="opt for opt in opts" ng-init="opts = [<?php $total = count(get_sub_field('subjects')) - 1; $c = 0; while(have_rows('subjects')) : the_row(); ?>'<?php the_sub_field('subject'); ?>'<?php if($c < $total) : ?>,<?php endif; ?><?php $c++; endwhile; ?>]" ng-model="formData.subject" required name="subject" ng-change="isDisabled = contactForm.subject.$invalid">
                    <option value="" selected><?php echo __('Scegli un oggetto', 'castadiva'); ?></option>
                </select>
                <i class="select-arrow select-arrow-inv"></i>
            </div>
        </div>
        <div class="carousel-item">
            <div class="form-container">
                <textarea placeholder="Messaggio" ng-model="formData.message" name="message" required ng-focus="isDisabled = contactForm.message.$invalid" ng-blur="isDisabled = contactForm.message.$invalid"></textarea>
            </div>
        </div>
    </div>
    <nav class="buttons">
        <div class="carousel-nav" ng-init="steps = [contactForm.sender,contactForm.email,contactForm.phone,contactForm.subject,contactForm.message]">
            <span class="arrow arrow-left" ng-click="dir(false, pos, 4, false, false)" ng-class="{inactive : pos == 0}"><span class="arrow-text">&lsaquo;</span></span>
            <button class="btn" ng-disabled="contactForm.$invalid"><span class="btn-text" ng-bind-html="(contactForm.$invalid) ? (pos + 1) + ' / 5' : '<?php echo __('Invia', 'castadiva'); ?>'"></span></button>
            <span class="arrow arrow-right" ng-click="dir(true, pos, 4, steps, false)" ng-class="{inactive : (pos == 4 || isDisabled)}"><span class="arrow-text">&rsaquo;</span></span>
        </div>
    </nav>
</form>