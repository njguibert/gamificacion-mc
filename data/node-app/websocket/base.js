const { SerialPort } = require('serialport')
const  {ReadlineParser} = require('@serialport/parser-readline')

const http = require("http")
/*const puertoserie = new SerialPort({
  path:"/home/jesus/virtual2",
  baudRate: 9600
})
const parser = new ReadlineParser();

puertoserie.pipe(parser)
*/
var dataSerial ="";

function comando(cmd){

  const datos = JSON.stringify(cmd);
  var options = {
      hostname: '192.168.6.22',
        port: 80,
        path: '/api.php',
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Content-Length': datos.length
      }        
  }; 

  return new Promise ((resolve,reject) =>{
    var req = http.request(options, function(res) {
      let api_res = "";
      res.setEncoding('utf8');
      res.on('data', function (chunk) {
        api_res+=chunk;
      });
      res.on("end", () => {
        console.log("Finalizo request"+api_res);
        resolve(api_res);
      });
    });

    req.on('error', function(e) {
      console.log('problem with request: ' + e.message);
    });    

    req.write(datos);
    req.end();      
  })

}

async function exec_comando(cmd) {
  try {
    var data=await comando(cmd);
    console.log("data:"+data)
  } catch (err){
    console.log("ERROR:"+err);
  }  
}


module.exports = function(io){

  io.on("connection",function(socket){
    console.log("Socket conectado");

    socket.on("run_cmd",function(cmd,callback){
      console.log("run_cmd:"+cmd);
      if (cmd=="rain_on"){
        console.log("Hacemos llover");
        exec_comando({cmd:"exec_comando",data:"do_rain_on"})
      } else if(cmd=="rain_off") {
        exec_comando({cmd:"exec_comando",data:"do_rain_off"})
        console.log("Hacemos parar de llover");
      }
      callback(true);
    });

    socket.on("send_txt",function(data,callback){
      console.log("Envio a la api php: "+data)
      exec_comando({cmd:"send_msg",data:data})
      
    });
  
  });

}