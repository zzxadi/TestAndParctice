(function(window, undefined){	
	function $(id){
		return document.querySelector('#'+id);
	}
	var canvas=$('canvas'), cxt=canvas.getContext('2d'), endX, startY, endY, Save = $('save'),
	    Clear = $('clear'), Brush=$('brush'), Eraser=$('eraser'), Paint=$('paint'), Straw=$('straw'), Text=$('text'), Magnifier=$('magnifier'), Line=$('line'), Arc=$('arc'), Rect=$('rect'), Poly=$('poly'), ArcFill=$('arcFill'), RectFill=$('rectFill'), actions=[Save,Clear,Brush,Eraser,Paint,Straw,Text,Magnifier,Line,Arc,Rect,Poly,ArcFill,RectFill], Width_1=$('width_1'), Width_3=$('width_3'), Width_5=$('width_5'), Width_8=$('width_8'), lineWidths=[Width_1,Width_3,Width_5,Width_8], flag = false, red=$('red'), green=$('green'), blue=$('blue'), yellow=$('yellow'), white=$('white'), black=$('black'), pink=$('pink'), purple=$('purple'), cyan=$('cyan'), orange=$('orange'), colors=[red,green,blue,yellow,white,black,pink,purple,cyan,orange];
	brush(3);
	function selectStatus(array,num,style){
		for(var i=0;i<array.length;i++){
			if(i==num){
				if(style==1){
					array[i].style.background='yellow';
				}else{
					array[i].style.border='1px solid #fff';
				}
				
			}else{
				if(style==1){
					array[i].style.background='#ccc';
				}else{
					array[i].style.border='1px solid #000';
				}
				
			}
		}
	}

	function saveas(num){
		var data=canvas.toDataURL();
		var b64 = data.substring( 22 );  
		var imgdata=$('imgdata');
		imgdata.value=b64;
		var form=$('form');
		form.submit(); 
		
	}
	function clearAll(num){
		selectStatus(actions,num,1);
		cxt.clearRect(0,0,800,400);
		canvas.onmousedown=null;
		canvas.onmousemove=null;
		canvas.onmouseup=null;
		canvas.onmouseout=null;
	}
	function brush(num){
		selectStatus(actions,num,1);
		canvas.onmousedown=function(evt){
				evt=evt?evt:window.event;
				startX = evt.pageX - this.offsetLeft;
				startY = evt.pageY - this.offsetTop; 
				flag=1;
				cxt.closePath();
				cxt.beginPath();
				cxt.moveTo(startX,startY); 
		}
			
		canvas.onmousemove=function(evt){
				evt=evt?evt:window.event;
				endX = evt.pageX - this.offsetLeft;
				endY = evt.pageY - this.offsetTop; 
				
				if(flag){
					cxt.lineTo(endX,endY);
					cxt.stroke();
					
				 }
		}
			
		canvas.onmouseup=function(evt){
				flag=0;
		}
		canvas.onmouseout=function(evt){
				flag=0;
		}
	}
	function eraser(num){
		selectStatus(actions,num,1);
		canvas.onmousedown=function(evt){
				evt=evt?evt:window.event;
				startX = evt.pageX - this.offsetLeft;
				startY = evt.pageY - this.offsetTop; 
				flag=1;
				cxt.clearRect(startX-cxt.lineWidth,startY-cxt.lineWidth,cxt.lineWidth,cxt.lineWidth);
				
		}
			
		canvas.onmousemove=function(evt){
				evt=evt?evt:window.event;
				endX = evt.pageX - this.offsetLeft;
				endY = evt.pageY - this.offsetTop; 
				
				if(flag){
					cxt.clearRect(endX-cxt.lineWidth,endY-cxt.lineWidth,cxt.lineWidth,cxt.lineWidth);	
				}
		}
			
		canvas.onmouseup=function(evt){
				flag=0;
		}
		canvas.onmouseout=function(evt){
				flag=0;
		}
	}
	function paint(num){
		selectStatus(actions,num,1);
		canvas.onmousedown=function(){
			cxt.fillRect(0,0,800,400);
		}
		
	}
	function straw(num){
		selectStatus(actions,num,1);
		canvas.onmousemove=null;
		canvas.onmouseup=null;
		canvas.onmouseout=null;
		canvas.onmousedown=function(evt){
			evt=evt?evt:window.event;
			X = evt.pageX - this.offsetLeft;
			Y = evt.pageY - this.offsetTop; 
			var imageData=cxt.getImageData(X,Y,1,1);
			var pxData=imageData.data;
			var color='rgba('+pxData[0]+','+pxData[1]+','+pxData[2]+','+pxData[3]+')';
			cxt.strokeStyle=color;
			cxt.fillStyle=color;
		}
	}
	function text(num){
		selectStatus(actions,num,1);
		
		canvas.onmousemove=null;
		canvas.onmouseup=null;
		canvas.onmouseout=null;
		canvas.onmousedown=function(evt){
			evt=evt?evt:window.event;
			startX = evt.pageX - this.offsetLeft;
			startY = evt.pageY - this.offsetTop; 
			var content=window.prompt('大小','');
			if(content){
				cxt.fillText(content,startX,startY);
			}
			
		}
	}
	function magnifier(num){
		selectStatus(actions,num,1);
		var scale=window.prompt('伸缩大小:','');
		var scaleX=780*scale/100;
		var scaleY=380*scale/100;
		canvas.style.width=parseInt(scaleX)+'px';
		canvas.style.height=parseInt(scaleY)+'px';
	}
	function line(num){
		selectStatus(actions,num,1);
		canvas.onmousedown=function(evt){
				evt=evt?evt:window.event;
				startX = evt.pageX - this.offsetLeft;
				startY = evt.pageY - this.offsetTop; 
				cxt.closePath();
				cxt.beginPath();
				cxt.moveTo(startX,startY); 
		}
		canvas.onmouseup=function(evt){
				evt=evt?evt:window.event;
				endX = evt.pageX - this.offsetLeft;
				endY = evt.pageY - this.offsetTop; 
				cxt.lineTo(endX,endY);
				cxt.stroke();
		}
		canvas.onmousemove=null;
		canvas.onmouseout=null;
		
		
	}
	function arc(num){
		selectStatus(actions,num,1);
		canvas.onmousedown=function(evt){
				evt=evt?evt:window.event;
				startX = evt.pageX - this.offsetLeft;
				startY = evt.pageY - this.offsetTop; 
				cxt.closePath();
				cxt.beginPath();
		}
		canvas.onmouseup=function(evt){
				evt=evt?evt:window.event;
				endX = evt.pageX - this.offsetLeft;
				endY = evt.pageY - this.offsetTop; 
				cxt.arc(startX,startY,Math.sqrt(Math.pow((endX-startX),2)+Math.pow((endY-startY),2)),0,360,false);
				cxt.stroke();
		}
		canvas.onmousemove=null;
		canvas.onmouseout=null;
	}
	function rect(num){
		selectStatus(actions,num,1);
		canvas.onmousedown=function(evt){
				evt=evt?evt:window.event;
				startX = evt.pageX - this.offsetLeft;
				startY = evt.pageY - this.offsetTop; 
		}
		canvas.onmouseup=function(evt){
				evt=evt?evt:window.event;
				endX = evt.pageX - this.offsetLeft;
				endY = evt.pageY - this.offsetTop; 
				cxt.strokeRect(startX,startY,endX-startX,endY-startY);
		}
		canvas.onmousemove=null;
		canvas.onmouseout=null;
	}
	function poly(num){
		selectStatus(actions,num,1);
		canvas.onmousedown=function(evt){
				evt=evt?evt:window.event;
				startX = evt.pageX - this.offsetLeft;
				startY = evt.pageY - this.offsetTop; 
				
				cxt.beginPath();
		}
		canvas.onmouseup=function(evt){
				evt=evt?evt:window.event;
				endX = evt.pageX - this.offsetLeft;
				endY = evt.pageY - this.offsetTop; 
				cxt.moveTo(endX,endY);
				cxt.lineTo(startX-(endX-startX),endY);
				cxt.lineTo(startX,startY-Math.sqrt(Math.sqrt(endX-startX,2)+Math.sqrt(endY-startY,2)));
				cxt.closePath();
				cxt.stroke();
				
		}
		canvas.onmousemove=null;
		canvas.onmouseout=null;
	}
	function arcFill(num){
		selectStatus(actions,num,1);
		canvas.onmousedown=function(evt){
				evt=evt?evt:window.event;
				startX = evt.pageX - this.offsetLeft;
				startY = evt.pageY - this.offsetTop; 
				cxt.closePath();
				cxt.beginPath();
		}
		canvas.onmouseup=function(evt){
				evt=evt?evt:window.event;
				endX = evt.pageX - this.offsetLeft;
				endY = evt.pageY - this.offsetTop; 
				cxt.arc(startX,startY,Math.sqrt(Math.pow((endX-startX),2)+Math.pow((endY-startY),2)),0,360,false);
				cxt.fill();
		}
		canvas.onmousemove=null;
		canvas.onmouseout=null;
	}
	function rectFill(num){
		selectStatus(actions,num,1);
		canvas.onmousedown=function(evt){
				evt=evt?evt:window.event;
				startX = evt.pageX - this.offsetLeft;
				startY = evt.pageY - this.offsetTop; 
		}
		canvas.onmouseup=function(evt){
				evt=evt?evt:window.event;
				endX = evt.pageX - this.offsetLeft;
				endY = evt.pageY - this.offsetTop; 
				cxt.fillRect(startX,startY,endX-startX,endY-startY);
		}
		canvas.onmousemove=null;
		canvas.onmouseout=null;
	}
	function setWidth(num){
		selectStatus(lineWidths,num,1);
		switch(num){
			case 0:
				cxt.lineWidth=1;
				break;
			case 1:
				cxt.lineWidth=3;
				break;
			case 2:
				cxt.lineWidth=5;
				break;
			case 3:
				cxt.lineWidth=8;
				break;
			default:
				break;
		}
	}
	function setColor(obj,num){
		selectStatus(colors,num);
		cxt.strokeStyle=obj.id;
		cxt.fillStyle=obj.id;
	}
	window.setColor = setColor;
	window.setWidth = setWidth;
	window.rect = rect;
	window.selectStatus = selectStatus;
	window.saveas = saveas;
	window.rectFill = rectFill;
	window.arcFill = arcFill;
	window.poly = poly;
	window.arc = arc;
	window.line = line;
	window.magnifier = magnifier;
	window.clearAll = clearAll;
	window.brush =brush;
	window.eraser = eraser;
	window.text = text;
	window.straw = straw;
	window.paint = paint;
}(this))