// import $ from 'jquery';
var $ = jQuery;

$("#buy-now-btn").on("click", function () {
	//判断按钮是否可点击
	if ($("#buy-now-btn").hasClass("disabled")) {
		//获取错误提示
		let msg = $("#tmpl-unavailable-variation-template").html();
		//去除制表符和p标签
		msg = msg.replace(/\t|\n|\v|\r|\f/g,'').replace(/<p>/gim,"").replace(/<\/p>/gim,"");
		alert( msg );
		return false;
	}
	//获取表单信息
	let form = $(".cart");
	let url = form.attr("action")
	let method = form.attr("method")
	let formData = new FormData(form[0]);
	//修改表单信息
	if(formData.has('add-to-cart')){
		let id = formData.get('add-to-cart');
		if (!id) {
			id = $("#buy-now-btn").val();
		}
	}else{
		id = $("#buy-now-btn").val();
		formData.set('add-to-cart', id);
		// console.log(formData.has('add-to-cart'));
	}

	// formData.delete('add-to-cart');
	// formData.set('buy-now', id);
	//提交表单
	$.ajax({
		method: method,
		url: url,
		data: formData,
		processData: false, //让jQuery不去处理发送的数据
		contentType: false,//让jQuery不去设置Content-Type请求头
		success: function (msg) {
			//跳转至结账页面
			window.location.href = "/checkout/";
		}
	});

	return false;
});