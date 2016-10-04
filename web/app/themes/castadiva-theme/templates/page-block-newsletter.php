<?php use Roots\Sage\Extras; ?>
<header class="container aligncenter row-btm row-lg-btm">
    <h4 class="title main-title">
        <?php echo __('Iscriviti alla nostra', 'castadiva'); ?>
        <strong>Newsletter</strong>
    </h4>
</header>
<form action="" novalidate>
    <div class="form-container">
        <input type="email" name="email" placeholder="<?php echo __('Inserisci il tuo indirizzo email', 'castadiva'); ?>" required />
    </div>
    <p class="buttons">
        <?php Extras\btn($text = __('Invia', 'castadiva'), $link = null, $btn = true); ?>
    </p>
</form>