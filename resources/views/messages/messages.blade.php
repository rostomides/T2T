@extends('layouts.app')

@section('content')


<div class="container">    
    
                    
            <div class="inbox_chat">
                <div class="chat_list"> 
                    <h2>You are talking to</h2>
                    
                    <div class="chat_people">
                    <div class="chat_img"> 
                    <img style="border-radius: 20px !important;" id="incoming-image"
                        @if(auth()->user()->role_id < 3)
                            src="{{ route('admin_pictures', [$profile->id,$main_pict]) }}"
                        @elseif($profile->id == auth()->user()->profile->id)
                            src="{{ route('my_pictures', [$profile->id,$profile->picture]) }}" 
                        @else
                            src="{{ route('picture', [$profile->id,$profile->picture]) }}"
                        @endif 
                        alt="sunil"> 
                    </div>
                    <div class="chat_ib">
                        <h5>{{ $profile->name }}</h5>
                        <p class="card-text">{{Carbon\Carbon::parse($profile->birthday)->diffInYears(Carbon\Carbon::now())}} years old</p>
                        <p class="card-text">{{ $profile->location }}</p> 
                    </div>
                    </div>
                </div> 
            </div>
                


            <div class="mesgs">
                <div class="msg_history" id="msg_history">
                    @if(sizeof($messages)>0)

                        @foreach($messages as $message)
                            @if($message->user_1 == auth()->user()->profile->id)

                                <div class="outgoing_msg">
                                    <div class="sent_msg">
                                    <p>{{ $message->message }}</p>
                                    <span class="time_date">{{Carbon\Carbon::parse($message->created_at)->diffForHumans()}}    |    {{date("Y-M-d", strtotime($message->created_at))}} </span> </div>
                                </div>
                            @else
                                <div class="incoming_msg">
                                        <div class="incoming_msg_img"> 
                                            <img style="border-radius: 20px !important;"  
                                                @if(auth()->user()->role_id < 3)
                                                    src="{{ route('admin_pictures', [$profile->id,$main_pict]) }}"
                                                @elseif($profile->id == auth()->user()->profile->id)
                                                    src="{{ route('my_pictures', [$profile->id,$profile->picture]) }}" 
                                                @else
                                                    src="{{ route('picture', [$profile->id,$profile->picture]) }}"
                                                @endif  
                                            alt="sunil"> 
                                        </div>
                                        <div class="received_msg">
                                        <div class="received_withd_msg">
                                            <p>{{ $message->message }}</p>
                                            <span class="time_date"> {{Carbon\Carbon::parse($message->created_at)->diffForHumans()}}    |    {{date("Y-M-d", strtotime($message->created_at))}}</span></div>
                                        </div>
                                    </div>
                            @endif
                        @endforeach
                    @else
                        <div class="container bg-warning">
                            You haven't exchanged any message with {{ $profile->name }} yet!
                        </div>

                    @endif
                </div>
                
                <div class="type_msg">
                    <div class="input_msg_write">
                        <form action="{{ route('store_message') }}" method="POST" id="message-form">
                            @csrf
                            <input type="hidden"  class="form-control" name="current_user" id="logged_user" value="{{ auth()->user()->profile->id }}">
                            <input type="hidden"  class="form-control" name="current_user" id="current_user" value="{{ $profile->id }}">

                            <div class="form-row">
                                <div class="col-11">
                                    <input style="padding-left:5px !important;" type="text" class="form-group" name="message" id="message"
                                        @if(is_null($still_matched)) 
                                            placeholder="You are no longer matched with {{ $profile->name }}" disabled
                                        @else
                                            placeholder="Type yout message here"
                                        @endif
                                    />
                                </div>
                                <div class="col-1 ml-0">
                                    <button  type="submit" class="msg_send_btn"
                                        @if(is_null($still_matched)) disabled @endif >
                                        <img src="{{ asset('svg/icons8-paper-plane-96.png') }}" alt="" >                     
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>    


@endsection






@section('javascript')

<script>
$( document ).ready(function() {   
    $('#msg_history').animate({scrollTop: $('#msg_history').prop("scrollHeight")}, 1);
    setInterval(function()
        {             
            // Update the messages area every 5 seconds
            get_messages()
        }, 5000);
    


    
    $('#message-form').on("submit", function(e){
        e.preventDefault();

        if($('#message').val() == "" ){
            alert("You cannot send an empty message!");
        }else{
            input_data = {
            "current_user": $('#current_user').val(),
            "message" : $('#message').val(),
            _token:$("input[name='_token']").val(),
            
            }  

            $.ajax({
                type:'POST',
                url:"{{ route('store_message') }}",
                data: input_data,
                success:function(data){ 
                $("#msg_history").empty();
                $("#msg_history").append(populate_messages(data));  
                $('#msg_history').animate({scrollTop: $('#msg_history').prop("scrollHeight")}, 0);    $('#message').val('');                       
                },
            });
        }    
    });

    function populate_messages(data){
        let current_user = $('#current_user').val();
        // console.log(data);
        var body =  ''
        var picture = $("#incoming-image").attr('src')        
        data.forEach(function(item){
            // console.log(item)
            if(item["user_1"] == current_user){
                body+= '<div class="incoming_msg"><div class="incoming_msg_img">';
                body+= '<img style="border-radius: 20px !important;"';
                body+= ' <img style="border-radius: 20px !important;" id="incoming-image" src="'+ picture + '"alt="sunil"></div><div class="received_msg"><div class="received_withd_msg">';
                body+='<p>' + item["message"] + '</p><span class="time_date">';
                body+= item["created_at"] +'</span></div></div></div>'
            }else{
                body+='<div class="outgoing_msg"><div class="sent_msg">'
                body+='<p>' + item["message"] + '</p><span class="time_date">';
                body+= item["created_at"] +'</span></div></div>'
            }
        });
        return(body);
    }


    function get_messages(){
        let current_user = $('#current_user').val();
        let logged_user = $('#logged_user').val();        

        $.ajax({
            type:'GET',
            url:'{{ route("return_messages",[auth()->user()->profile->id, $profile->id]) }}',           
            success:function(data){ 
               $("#msg_history").empty();
               $("#msg_history").append(populate_messages(data)); 
               $('#msg_history').animate({scrollTop: $('#msg_history').prop("scrollHeight")}, 0);
            },
        });  
    }

});
    


</script>




















@endsection






@section("css")
<style>
    .container{max-width:1170px; margin:auto;}
img{ max-width:100%;}
.inbox_people {
  background: #f8f8f8 none repeat scroll 0 0;
  float: left;
  overflow: hidden;
  width: 40%; border-right:1px solid #c4c4c4;
}
.inbox_msg {
  border: 1px solid #c4c4c4;
  clear: both;
  overflow: hidden;
}
.top_spac{ margin: 20px 0 0;}


.recent_heading {float: left; width:40%;}
.srch_bar {
  display: inline-block;
  text-align: right;
  width: 60%; padding:
}
.headind_srch{ padding:10px 29px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;}

.recent_heading h4 {
  color: #05728f;
  font-size: 21px;
  margin: auto;
}
.srch_bar input{ border:1px solid #cdcdcd; border-width:0 0 1px 0; width:80%; padding:2px 0 4px 6px; background:none;}
.srch_bar .input-group-addon button {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  padding: 0;
  color: #707070;
  font-size: 18px;
}
.srch_bar .input-group-addon { margin: 0 0 0 -27px;}

.chat_ib h5{ font-size:15px; color:#464646; margin:0 0 8px 0;}
.chat_ib h5 span{ font-size:13px; float:right;}
.chat_ib p{ font-size:14px; color:#989898; margin:auto}
.chat_img {
  float: left;
  width: 11%;
}
.chat_ib {
  float: left;
  padding: 0 0 0 15px;
  width: 88%;
}

.chat_people{ overflow:hidden; clear:both;}
.chat_list {
  border-bottom: 1px solid #c4c4c4;
  margin: 0;
  padding: 18px 16px 10px;
}
/* .inbox_chat { height: 550px; overflow-y: scroll;} */

.active_chat{ background:#ebebeb;}

.incoming_msg_img {
  display: inline-block;
  width: 50px;
  
}
.received_msg {
  display: inline-block;
  padding: 0 0 0 10px;
  vertical-align: top;
  width: 92%;
 }
 .received_withd_msg p {
  background:  #05728f none repeat scroll 0 0;
  border-radius: 3px;
  color: white;
  font-size: 14px;
  margin: 0;
  padding: 5px 10px 5px 12px;
  width: 100%;
}
.time_date {
  color: #747474;
  display: block;
  font-size: 12px;
  margin: 8px 0 0;
}
.received_withd_msg { width: 57%;}
.mesgs {
  /* float: left; */
  padding: 30px 15px 0 25px;
  /* width: 60%; */
}

 .sent_msg p {
  background: #dc143c none repeat scroll 0 0;
  border-radius: 3px;
  font-size: 14px;
  margin: 0; color:#fff;
  padding: 5px 10px 5px 12px;
  width:100%;
}
.outgoing_msg{ overflow:hidden; margin:26px 0 26px;}
.sent_msg {
  float: right;
  width: 46%;
}
.input_msg_write input {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  color: #4c4c4c;
  font-size: 15px;
  min-height: 48px;
  width: 100%;
}

.type_msg {border-top: 1px solid #c4c4c4;position: relative;}
.msg_send_btn {
  background: #dc143c  none repeat scroll 0 0;
  border: medium none;
  border-radius: 50%;
  color: #fff;
  cursor: pointer;
  font-size: 17px;
  height: 33px;
  position: absolute;
  right: 0;
  top: 11px;
  width: 33px;
}
.messaging { padding: 0 0 50px 0;}
.msg_history {
  height: 516px;
  overflow-y: auto;
}
 


</style>



@endsection