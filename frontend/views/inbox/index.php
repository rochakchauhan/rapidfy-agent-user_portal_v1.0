<?php extract($getUserInfo); ?>
<style type="text/css">
	#searchid{
		color:#fff;
	}
	.chat-txt input[type="text"] {
		color:#fff;
	}
	.chat-available-user li.active{
		background-color:#F7F7F6;
	}
	#preloader{		
		width:10%;
		z-index: 9999900;
		background-color:#C23321;
		color:#fff;
	}
	#preloader h1{
		text-align:center;
		font-weight:bold;
		size:32px;
		color:#fff;
	}
	#preloaderOld{
		position:fixed;
		top:0px;
		left:0px;
		width: 110%;
		height: 110%;
		background-color:#00A8B3;
		z-index: 9999900;
		opacity: 0.3;
    	filter: alpha(opacity=30);
	}
	#preloaderOLD h1{
		opacity: 1;
    	filter: alpha(opacity=100);
    	margin:100px;
    	z-index: 9999999;
		padding:100px;
    	top:0px;
		left:0px;
		color:#000;
		text-align:center;
	}
	#_btngroupid{
		position:fixed;
		top: 15%;
		left:50%;
	}
	#msgDiv{
		overflow:auto;
		max-height: 300px;
	}
	#alertdiv{
		display:none;
	}
</style>

<div class="row">
	<div class="col-md-4">&nbsp;</div>
  	<div class="col-md-4" style="display: block;" id="preloader">Loading...</div>
  	<div class="col-md-4">&nbsp;</div>
</div>

<div id="alertdiv" class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>ERROR :: </strong><span id="error_message">Loading...</span>
</div>


<!-- page start-->
<div class="chat-room">
	<aside class="left-side">
		<div class="user-head">
			<i class="fa fa-comments-o"></i>
			<h3>Request Inbox</h3>
		</div> 
		<ul class="chat-list">
			<li class="">
				<a class="lobby" href="/inbox"> <h4><i class="fa fa-list"></i> Conversations </h4> </a>
			</li>
			<div id='cdiv'>
				<li><a href="#"><span> Loading...</span></a></li>   
			</div>			
		</ul>
		
	</aside>
	<aside class="mid-side">
		<div class="chat-room-head">
			<h3 id="keyword">&nbsp;</h3>
		</div>
		<p>&nbsp;</p>
		<div id="btngroupid" style="display: none;" class="form-inline">
	 		<div class="form-group">
				&nbsp;&nbsp;  
				<input type="text" size="46" class="form-control input-md" id="rapidfy_content">
				<div class="btn-group">
					&nbsp;&nbsp;
					<button style="display:none;" id="sendbutton" class="btn btn-success btn-md" onclick="sendMessage()">
						Send
					</button>
					<button style="display:none;" id="closedbutton" class="btn btn-danger btn-md" disabled="disabled">
						Closed
					</button>
				</div>
			</div>
		</div>
		<div id='msgDiv'>&nbsp;</div>		
		<footer id="msgbar" style="display:none">
			
			<input type="hidden" id="rapidfy_id" value="<?php echo $id; ?>" />
			<input type="hidden" id="rapidfy_token" value="<?php echo $token; ?>"/>
			<input type="hidden" id="rapidfy_username" value="<?php echo $username; ?>"/>
			<input type="hidden" id="rapidfy_serviceName" />
			<input type="hidden" id="rapidfy_status" />
			
			<input type="hidden" id="rapidfy_request_id" />
			<input type="hidden" id="rapidfy_responses_id" />
			
		</footer>
	</aside>
	<aside class="right-side">
		<div class="user-head">
			<h4 class="pull-left">Request Detail</h4>
		</div>
		
		
		<div style="margin-left: 10px;display:none;" id="requestDiv">
			<div class="form-group">
		    	<label>Service Description:</label>
		    	<div>
		    		<textarea style="resize: none;" class="form-control" readonly="readonly" disabled="disabled" id="request_description"></textarea>
		    	</div>
	  		</div>
	  		<div class="form-group">
		    	<label>When:</label>
		    	<div>
		    		<span id="request_when"></span>
		    	</div>
	  		</div>
	  		<div class="form-group">
		    	<label>Where:</label>
		    	<div>
		    		<span id="request_where"></span>
		    	</div>
	  		</div>
	  		<div class="form-group">
		    	<label>Status:</label>
		    	<div>
		    		<span id="request_status"></span>
		    	</div>
	  		</div>
	  		<div class="form-group">
		    	<label>Reference Number:</label>
		    	<div>
		    		<span id="request_refno"></span>
		    	</div>
	  		</div>
	  	</div>
	  
		<!--footer>
			<a href="#" class="guest-on"> <i class="fa fa-check"></i> Guest Access On </a>
		</footer-->
	</aside>
</div>
<!-- page end-->
</section>
</section>
<!--main content end-->


