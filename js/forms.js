DingesForm = function(formEl) {
	this.form = formEl;
	var bla = this;
	this.form.onsubmit = function() {
		bla.validate();
	};
}

DingesForm.prototype = {
	form: null
};

DingesForm.prototype.validate = function() {
	var ok = false;
	for(var i = 0; i < this.form.length; i++) {
		if(this.form[i].getAttribute('required') == 'true' && this.form[i].value == '') {
			alert(this.form[i].id);
		}
	}
}
