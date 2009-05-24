function DingesForm(formEl) {
	this.form = formEl;
	this.fields = {};
	var self = this;
	this.form.onsubmit = function() {
		return self.validate();
	};
}

DingesForm.prototype = {
	form: null,
	fields: null,
	errorIcon: null
};

DingesForm.prototype.addField = function(name, field) {
	this.fields[name] = field;
	field.setForm(this);
}

DingesForm.prototype.setFocus = function(fname) {
	this.fields[fname].field.focus();
}

DingesForm.prototype.validate = function() {
	var ok = true;
	for(var i in this.fields) {
		var result = this.fields[i].validate();
		if(result !== true) {
			this.fields[i].setError(result);
			ok = false;
		} else {
			this.fields[i].removeError();
		}
	}
	return ok;
}

DingesForm.prototype.setErrorIcon = function(src) {
	this.errorIcon = src;
}

function DingesFormField(fieldEl) {
	this.restrictions = {};
	this.field = fieldEl;
	this.label = document.getElementById(fieldEl.id +'_label');
	this.error = document.getElementById(fieldEl.id +'_error');
	var comment = this.field.nextSibling;
	if(comment && comment.nodeType == 8) {
		var restrs = comment.nodeValue.split(' ');
		for(var i = 0; i < restrs.length; i++) {
			restr = restrs[i].split('=');
			if(restr.length == 2) {
				this.restrictions[restr[0]] = restr[1];
			}
		}
	}
}

DingesFormField.prototype = {
	form: null,
	field: null,
	label: null,
	error: null, // let op: dat is het error-span element
	type: null,
	restrictions: null
};

DingesFormField.prototype.setForm = function(form) {
	this.form = form;
}

/**
 * - floating box
 * - errorDiv per veld
 * - error script (user defined callback)
 */
DingesFormField.prototype.validate = function() {
	var result = true;
	for(var restriction in this.restrictions) {
		if(restriction == 'required' && this.restrictions[restriction] == 'true' && this.field.value == '') {
			result = 'ERR_EMPTY';
			break;
		} else if(restriction == 'maxLength' && this.field.value.length > this.restrictions[restriction]) {
			result = 'ERR_OVER_MAXLENGTH';
			break;
		} else if(restriction == 'minLength' && this.field.value.length < this.restrictions[restriction]) {
			result = 'ERR_OVER_MINLENGTH';
			break;
		} else if(restriction == 'min' && !isNaN(this.field.value) && parseInt(this.field.value) < this.restrictions[restriction]) {
			result = 'ERR_OVER_MAX';
			break;
		} else if(restriction == 'max' && !isNaN(this.field.value) && parseInt(this.field.value) > this.restrictions[restriction]) {
			result = 'ERR_UNDER_MIN';
			break;
		}
	}
	return result;
}

DingesFormField.prototype.setError = function (errorCode) {
	this.setErrorSpan(errorCode); // XXX vertalen
	dinges_addClass(this.field, 'dingesError');
	if(this.label) {
		dinges_addClass(this.label, 'dingesErrorLabel');
	}
}

DingesFormField.prototype.removeError = function () {
	this.setErrorSpan('');
	dinges_removeClass(this.field, 'dingesError');
	if(this.label) {
		dinges_removeClass(this.label, 'dingesErrorLabel');
	}
}

DingesFormField.prototype.setErrorSpan = function (text) {
	if(this.error) {
		if(this.form.errorIcon) {
			if(text) {
				this.error.innerHTML = '';
				var img = document.createElement('img');
				img.alt = text;
				img.src = this.form.errorIcon;
				img.onclick = function () { alert(text); }
				this.error.appendChild(img);
			} else {
				this.error.innerHTML = '';
			}
		} else {
			this.error.innerHTML = text;
		}
	}
}

function dinges_addClass(el, className) {
	el.className += ' '+ className;
}

function dinges_removeClass(el, className) {
	var classes = el.className.split(/ /);
	for(var i = 0; classes.length>i; i++) {
		if(classes[i] == className) {
			delete classes[i];
			break;
		}
	}
	el.className = classes.join(' ');
}
