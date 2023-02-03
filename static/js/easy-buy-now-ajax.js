(function ($){
	$("#easy-buy-now").on("click", function () {
		console.log("easybuynow");
		//获取表单信息
		let form = $(".cart");
		let url = form.attr("action")
		let method = form.attr("method")
		let formData = new FormData(form[0]);
		let id;
		//修改表单信息
		if(formData.has('add-to-cart')){
			id = formData.get('add-to-cart');
			if (!id) {
				id = $("#easy-buy-now").val();
			}
		}else{
			id = $("#easy-buy-now").val();
			formData.set('add-to-cart', id);
			// console.log(formData.has('add-to-cart'));
		}

		// formData.delete('add-to-cart');
		formData.set('easy-buy-now', id);
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
}(jQuery))
