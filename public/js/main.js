var App = Class({
	initialize: function(name, age) {
		this.name = name;
		this.age  = age;
	},
	toString: function() {
		return "My name is "+this.name+" and I am "+this.age+" years old.";
	}
});
