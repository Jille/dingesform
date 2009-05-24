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
	fields: null
};

DingesForm.prototype.validate = function() {
	var ok = true;
	for(var i in this.fields) {
		var result = this.fields[i].validate();
		if(result !== true) {
			this.fields[i].setErrorClass();
			ok = false;
		} else {
			this.fields[i].removeErrorClass();
		}
	}
	return ok;
}

function DingesFormField(fieldEl, labelId) {
	this.restrictions = {};
	this.field = fieldEl;
	if(labelId) {
		labelEl = document.getElementById(labelId)
		if(labelEl) {
			this.label = labelEl;
		}
	}
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
	field: null,
	label: null,
	type: null,
	restrictions: null
};

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
			result = 'ERR_TOO_LONG';
			break;
		} else if(restriction == 'min' && !isNaN(this.field.value) && parseInt(this.field.value) < this.restrictions[restriction]) {
			result = 'ERR_TOO_LARGE';
			break;
		} else if(restriction == 'max' && !isNaN(this.field.value) && parseInt(this.field.value) > this.restrictions[restriction]) {
			result = 'ERR_TOO_SMALL';
			break;
		}
	}
	return result;
}

DingesFormField.prototype.setErrorClass = function () {
	dinges_addClass(this.field, 'dingesError');
	if(this.label) {
		dinges_addClass(this.label, 'dingesErrorLabel');
	}
}

DingesFormField.prototype.removeErrorClass = function () {
	dinges_removeClass(this.field, 'dingesError');
	if(this.label) {
		dinges_removeClass(this.label, 'dingesErrorLabel');
	}
}

function dinges_addClass(el, class) {
	el.className += ' '+ class;
}

function dinges_removeClass(el, class) {
	var classes = el.className.split(/ /);
	for(var i = 0; classes.length>i; i++) {
		if(classes[i] == class) {
			delete classes[i];
			break;
		}
	}
	el.className = classes.join(' ');
}
