$(document).ready(function(){
  const socket=io("http://"+self.location.hostname+":4000");
  socket.on("connect",()=>{
    console.log("Id del websocket:"+socket.id);
  })
  socket.on("api_request",function(json){
    console.log("api_request:"+json.data);
    $("#lbl_data_from_game").text(json.value);
  })

  $("#btn_rain_on").click(function(){
    socket.emit("run_cmd","rain_on",function(data){
      console.log("Valor de callback:"+data);
    })
  });

  $("#btn_rain_off").click(function(){
    socket.emit("run_cmd","rain_off",function(data){
      console.log("Valor de callback:"+data);
    })
  });  

  $("#btn_send_msg").click(function(){
    socket.emit("send_txt",$("#txt_send_msg").val(),function(data){
      console.log("Valor de callback:"+data);
    })
  }); 
});