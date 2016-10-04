jQuery(document).ready(function ($) {

	$('#a-sumk-metabox input, #a-sumk-metabox textarea').placeholder();

	var $slug = $('#sumk-slug-field'),
		shortcode = $slug.val();
	$('.su-generator-button').attr('data-shortcode', shortcode);

	$('#sumk-name-field').on('blur', function (e) {
		if ($slug.val() == '') $slug.val($(this).val().toLowerCase().replace(/ /g, '_').replace(/[^a-z0-9_]/g, ""));
	});

	var editor = ace.edit('sumk-code-field-editor'),
		$textarea = $('#sumk-code-field').hide();
	editor.getSession().setValue($textarea.val());
	editor.getSession().on('change', function () {
		$textarea.val(editor.getSession().getValue());
	});
	editor.setTheme('ace/theme/monokai');
	editor.getSession().setUseWrapMode(true);
	editor.getSession().setWrapLimitRange(null, null);
	editor.renderer.setShowPrintMargin(null);
	editor.session.setUseSoftTabs(null);

	$slug.keypress(function (e) {
		return validate_slug(e);
	});

	$('.sumk-variables.description').on('click', 'a', function (e) {
		e.preventDefault();
		editor.insert($(this).text());
		window.setTimeout(function () {
			editor.focus();
		}, 100);
	});

	$('input[name="sumk_code_type"]').on('change', function (e) {
		window.sumk_attr_prefix = '';
		window.sumk_attr_postfix = '';
		switch ($(this).val()) {
		case 'html':
			editor.getSession().setMode('ace/mode/html');
			window.sumk_attr_prefix = '{{';
			window.sumk_attr_postfix = '}}';
			break;
		case 'php_return':
			editor.getSession().setMode({
				path: 'ace/mode/php',
				inline: true
			});
			window.sumk_attr_prefix = '$';
			break;
		case 'php_echo':
			editor.getSession().setMode({
				path: 'ace/mode/php',
				inline: true
			});
			window.sumk_attr_prefix = '$';
			break;
		}
		variables();
		$('.sumk-attr-prefix').text(window.sumk_attr_prefix);
		$('.sumk-attr-postfix').text(window.sumk_attr_postfix);
	}).filter(':checked').trigger('change');

	$('.sumk-help-button').magnificPopup({
		type: 'inline'
	});

	$('body').on('click', '.sumk-click2select', function (e) {
		e.target.select();
	});

	$('.sumk-add-attribute').click(function (e) {
		var $attr = $(tmpl('sumk_tmpl_attribute', {}));
		$('.sumk-attributes .sumk-attribute').removeClass('sumk-attribute-editable');
		$attr.prependTo('.sumk-attributes:first');
		$attr.addClass('sumk-attribute-editable');
		$attr.find('input, textarea').placeholder();
		$attr.find('.sumk-attr-prefix').text(window.sumk_attr_prefix);
		$attr.find('.sumk-attr-postfix').text(window.sumk_attr_postfix);
		$attr.find('input:first').focus();
		index_attributes();
		e.preventDefault();
	});

	$('.sumk-attr-head span').live('click', function (e) {
		e.stopPropagation();
		var $attr = $(this).parents('.sumk-attribute');
		$attr.addClass('sumk-attribute-removing').animate({
			opacity: 0
		}, 300, function () {
			$(this).remove();
			index_attributes();
			variables();
		});
	});

	$('.sumk-attribute-slug-value').live({
		keyup: function (e) {
			$(this).parents('.sumk-attribute').find('.sumk-attr-head strong').text($(this).val());
		},
		keypress: function (e) {
			return validate_slug(e);
		},
		blur: variables
	});

	$('.sumk-attribute-type-select').live('change', function () {
		var
		$select = $(this),
			$attr = $select.parents('.sumk-attribute'),
			is_detailed = $attr.hasClass('sumk-attribute-detailed');
		$attr.attr('class', 'sumk-attribute sumk-attribute-editable sumk-attribute-type-' + $select.val());
		if (is_detailed) $attr.addClass('sumk-attribute-detailed');
	});

	$('.sumk-attr-head').live('click', function (e) {
		var $attr = $(this).parents('.sumk-attribute'),
			is_active = $attr.hasClass('sumk-attribute-editable');
		// Close all attributes
		$('.sumk-attribute').removeClass('sumk-attribute-editable');
		// Open current attr if not active
		if (!is_active) $attr.addClass('sumk-attribute-editable');
		variables();
		e.preventDefault();
	});

	$('.sumk-attr-head a').live('click', function (e) {
		e.preventDefault();
	});

	$('.sumk-attributes').sortable({
		revert: 300,
		tolerance: 'intersect',
		placeholder: 'sumk-sort-placeholder',
		cursorAt: {
			left: -5,
			top: -5
		},
		helper: function (e, ui) {
			var name = ui.find('.sumk-attr-head strong').text();
			return '<b class="sumk-sort-helper">' + name + '</b>';
		},
		stop: function () {
			index_attributes();
			variables();
		}
	});

	$('form#post').submit(function (e) {
		validate(e);
	});
	$('input#publish').click(function (e) {
		validate(e);
	});

	$('.sumk-attr-toggle-details a').live('click', function (e) {
		$(this).parents('.sumk-attribute').toggleClass('sumk-attribute-detailed');
		e.preventDefault();
	});

	function variables() {
		var $vars = $('.sumk-variables span'),
			vars = [],
			$atts = $('.sumk-attributes .sumk-attribute'),
			before = window.sumk_attr_prefix,
			after = window.sumk_attr_postfix;
		// Add content variable
		vars.push('<a href="#">' + before + 'content' + after + '</a>');
		// Get attributes vars
		$atts.each(function () {
			var value = $(this).find('.sumk-attribute-slug-value').val();
			if (value != '') vars.push('<a href="#">' + before + value + after + '</a>');
		});
		// Show variables
		$vars.html(vars.join(', '));
	}

	variables();

	function validate(e) {
		$('.sumk-invalid-field').removeClass('sumk-invalid-field');
		$('.sumk-req-fields-message').fadeOut(300);
		$('.sumk-req-field').each(function (i) {
			var $field = $(this).find('input:text, textarea').filter(':first');
			if ($field.val() == '') {
				$(this).addClass('sumk-invalid-field');
				$('#submitdiv .spinner').hide();
				$('#publish, #save-post').removeClass('button-primary-disabled button-disabled');
				$('.sumk-req-fields-message').fadeIn(300);
				$(window).scrollTop(0);
				e.preventDefault();
			}
		});
	}

	function index_attributes() {
		var $atts = $('.sumk-attributes .sumk-attribute');

		$atts.each(function (i) {
			$(this).find('input, select, textarea').each(function (i2) {
				$(this).attr('name', $(this).attr('name').replace(/\d+/, i));
				$(this).attr('id', $(this).attr('id').replace(/\d+/, i));
			});
			$(this).find('label').each(function (i3) {
				$(this).attr('for', $(this).attr('for').replace(/\d+/, i));
			});
		});
	}

	function validate_slug(event) {
		var englishAlphabetAndUnderscore = /[a-z0-9_]/g;
		var key = String.fromCharCode(event.which);
		return event.keyCode == 8 || event.keyCode == 37 || event.keyCode == 39 || englishAlphabetAndUnderscore.test(key);
	}

	$('.sumk-field-icon').on('click', '.button', function (e) {
		var $btn = $(this),
			$field = $btn.parents('.sumk-field-icon'),
			$img = $field.find('img'),
			$val = $field.find('input[type="hidden"]'),
			frame;
		if (typeof (frame) !== 'undefined') frame.close();
		frame = wp.media.frames.customHeader = wp.media({
			title: sumk.icon_title,
			library: {
				type: 'image'
			},
			button: {
				text: sumk.icon_insert
			},
			multiple: false
		});
		frame.on('select', function () {
			var attachment = frame.state().get('selection').first().toJSON();
			$val.val(attachment.url);
			$img.attr('src', attachment.url);
		});
		frame.open();
		e.preventDefault();
	});

	/* Tiny template system */
	(function () {
		var a = {};
		this.tmpl = function b(c, d) {
			var e = !/\W/.test(c) ? a[c] = a[c] || b(document.getElementById(c).innerHTML) : new Function("obj", "var p=[],print=function(){p.push.apply(p,arguments);};" + "with(obj){p.push('" +
				c.replace(/[\r\t\n]/g, " ").split("<%").join("	").replace(/((^|%>)[^\t]*)'/g, "$1\r").replace(/\t=(.*?)%>/g, "',$1,'").split("	").join("');").split("%>").join("p.push('").split("\r").join("\\'") +
				"');}return p.join('');");
			return d ? e(d) : e
		}
	})();
});