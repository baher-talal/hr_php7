<form method="post" action="{{ url('api/replay') }}" role="form">
	token<input type="text" name ="mobile_token"/><br/>
	message<input type="text" name ="message"/><br/>
	status<input type="text" name ="status"/><br/>
	parent<input type="text" name ="parent"/><br/>
	<input type="submit"  value="submit"/>	
</form>