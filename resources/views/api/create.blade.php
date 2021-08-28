<form method="post" action="{{ url('api/inquiryCreate') }}" role="form">
	token<input type="text" name ="mobile_token"/><br/>
	title<input type="text" name ="title"/><br/>
	message<input type="text" name ="message"/><br/>
	department<input type="text" name ="department_id"/><br/>
	user<input type="text" name ="to"/><br/>
	status<input type="text" name ="status"/><br/>
	parent<input type="text" name ="parent"/><br/>
	<input type="submit"  value="submit"/>	
</form>