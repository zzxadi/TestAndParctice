function isType(type){
	return function(obj){
		return Object.prototype.toString.call(obj) == '[object ' + type + ']';
	}
}

var isString = isType('String');
var isArray = isType('Array');