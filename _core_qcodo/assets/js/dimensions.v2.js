/*
 * Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
 * and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
 *
 * $LastChangedDate: 2007-03-27 23:29:43 +0200 (Di, 27 Mrz 2007) $
 * $Rev: 1601 $
 */
jQuery.fn._height = jQuery.fn.height;
jQuery.fn._width = jQuery.fn.width;
jQuery.fn.height = function () {
	if (this[0] == window) return self.innerHeight || jQuery.boxModel && document.documentElement.clientHeight || document.body.clientHeight;
	if (this[0] == document) return Math.max(document.body.scrollHeight, document.body.offsetHeight);
	return this._height(arguments[0])
};
jQuery.fn.width = function () {
	if (this[0] == window) return self.innerWidth || jQuery.boxModel && document.documentElement.clientWidth || document.body.clientWidth;
	if (this[0] == document) return Math.max(document.body.scrollWidth, document.body.offsetWidth);
	return this._width(arguments[0])
};
jQuery.fn.innerHeight = function () {
	return this[0] == window || this[0] == document ? this.height() : this.css('display') != 'none' ? this[0].offsetHeight - (parseInt(this.css("borderTopWidth")) || 0) - (parseInt(this.css("borderBottomWidth")) || 0) : this.height() + (parseInt(this.css("paddingTop")) || 0) + (parseInt(this.css("paddingBottom")) || 0)
};
jQuery.fn.innerWidth = function () {
	return this[0] == window || this[0] == document ? this.width() : this.css('display') != 'none' ? this[0].offsetWidth - (parseInt(this.css("borderLeftWidth")) || 0) - (parseInt(this.css("borderRightWidth")) || 0) : this.height() + (parseInt(this.css("paddingLeft")) || 0) + (parseInt(this.css("paddingRight")) || 0)
};
jQuery.fn.outerHeight = function () {
	return this[0] == window || this[0] == document ? this.height() : this.css('display') != 'none' ? this[0].offsetHeight: this.height() + (parseInt(this.css("borderTopWidth")) || 0) + (parseInt(this.css("borderBottomWidth")) || 0) + (parseInt(this.css("paddingTop")) || 0) + (parseInt(this.css("paddingBottom")) || 0)
};
jQuery.fn.outerWidth = function () {
	return this[0] == window || this[0] == document ? this.width() : this.css('display') != 'none' ? this[0].offsetWidth: this.height() + (parseInt(this.css("borderLeftWidth")) || 0) + (parseInt(this.css("borderRightWidth")) || 0) + (parseInt(this.css("paddingLeft")) || 0) + (parseInt(this.css("paddingRight")) || 0)
};
jQuery.fn.scrollLeft = function () {
	if (this[0] == window || this[0] == document) return self.pageXOffset || jQuery.boxModel && document.documentElement.scrollLeft || document.body.scrollLeft;
	return this[0].scrollLeft
};
jQuery.fn.scrollTop = function () {
	if (this[0] == window || this[0] == document) return self.pageYOffset || jQuery.boxModel && document.documentElement.scrollTop || document.body.scrollTop;
	return this[0].scrollTop
};
jQuery.fn.offset = function (options, returnObject) {
    var isOpera = ( !! window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
    var isFirefox = typeof InstallTrigger !== 'undefined';
    var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) {
        return p.toString() === "[object SafariRemoteNotification]"
    })(!window['safari'] || (typeof safari !== 'undefined' && safari.pushNotification));
    var isIE =
    /*@cc_on!@*/
    false || !!document.documentMode;
	var x = 0,
	y = 0,
	elem = this[0],
	parent = this[0],
	absparent = false,
	relparent = false,
	op,
	sl = 0,
	st = 0,
	options = jQuery.extend({
		margin: true,
		border: true,
		padding: false,
		scroll: true
	},
	options || {});
	do {
		x += parent.offsetLeft || 0;
		y += parent.offsetTop || 0;
		if (isFirefox || isIE) {
			var bt = parseInt(jQuery.css(parent, 'borderTopWidth')) || 0;
			var bl = parseInt(jQuery.css(parent, 'borderLeftWidth')) || 0;
			x += bl;
			y += bt;
			if (isFirefox && parent != elem && jQuery.css(parent, 'overflow') != 'visible') {
				x += bl;
				y += bt
			}
			if (jQuery.css(parent, 'position') == 'absolute') absparent = true;
			if (jQuery.css(parent, 'position') == 'relative') relparent = true
		}
		if (options.scroll) {
			op = parent.offsetParent;
			do {
				sl += parent.scrollLeft || 0;
				st += parent.scrollTop || 0;
				parent = parent.parentNode;
				if (isFirefox && parent != elem && parent != op && jQuery.css(parent, 'overflow') != 'visible') {
					x += parseInt(jQuery.css(parent, 'borderLeftWidth')) || 0;
					y += parseInt(jQuery.css(parent, 'borderTopWidth')) || 0
				}
			} while (op && parent != op)
		} else parent = parent.offsetParent;
		if (parent && (parent.tagName.toLowerCase() == 'body' || parent.tagName.toLowerCase() == 'html')) {
			if ((isSafari || (isIE && jQuery.boxModel)) && jQuery.css(elem, 'position') != 'absolute') {
				x += parseInt(jQuery.css(parent, 'marginLeft')) || 0;
				y += parseInt(jQuery.css(parent, 'marginTop')) || 0
			}
			if ((isFirefox && !absparent) || (isIE && jQuery.css(elem, 'position') == 'static' && (!relparent || !absparent))) {
				x += parseInt(jQuery.css(parent, 'borderLeftWidth')) || 0;
				y += parseInt(jQuery.css(parent, 'borderTopWidth')) || 0
			}
			break
		}
	} while (parent);
	if (!options.margin) {
		x -= parseInt(jQuery.css(elem, 'marginLeft')) || 0;
		y -= parseInt(jQuery.css(elem, 'marginTop')) || 0
	}
	if (options.border && (isSafari || isOpera)) {
		x += parseInt(jQuery.css(elem, 'borderLeftWidth')) || 0;
		y += parseInt(jQuery.css(elem, 'borderTopWidth')) || 0
	} else if (!options.border && !(isSafari || isOpera)) {
		x -= parseInt(jQuery.css(elem, 'borderLeftWidth')) || 0;
		y -= parseInt(jQuery.css(elem, 'borderTopWidth')) || 0
	}
	if (options.padding) {
		x += parseInt(jQuery.css(elem, 'paddingLeft')) || 0;
		y += parseInt(jQuery.css(elem, 'paddingTop')) || 0
	}
	if (options.scroll && isOpera && jQuery.css(elem, 'display') == 'inline') {
		sl -= elem.scrollLeft || 0;
		st -= elem.scrollTop || 0
	}
	var returnValue = options.scroll ? {
		top: y - st,
		left: x - sl,
		scrollTop: st,
		scrollLeft: sl
	}: {
		top: y,
		left: x
	};
	if (returnObject) {
		jQuery.extend(returnObject, returnValue);
		return this
	} else {
		return returnValue
	}
};