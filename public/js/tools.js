
function abreviaturaMes(mes){
    const meses = ["EN","FEBR","MZO","ABR","MY","JUN","JUL","AGTO","SPT","OCT","NOV","DIC"]

    return meses[$mes];

}
function  abreviaturaMesIngles(mes){
    const meses = ["JAN","FEB","MAR","APR","MAY","JUNE","JULY","AUG","SEPT","OCT","NOV","DEC"];

    return meses[mes];
}
function getdiasSemanas(idioma){
    if (idioma=='es'){
        return ['Dom', 'Lun', 'Mar', 'Mir', 'Jue', 'Vie', 'Sab']
    }else{
        return ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fir', 'Sat']
    }

}
function getMesAbreLinst(idioma) {

    if (idioma=='es'){
        return ["En","Febr","Mzo","Abr","My","Jun","Jul","Agto","Spt","Oct","Nov","Dic"];
    }else {
        return   ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    }
}
function renombrarURL(url,titulo='',data=null) {
    window.history.pushState(data, titulo, url);
}
function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}
function getPathURL() {
    return location.href.slice(_URL.length);
}
function _ajaxDOM(url,contenedor_id) {
    $.ajax({
        type: 'POST',
        url: _URL+url,
        success: function (resp) {
            $("#loader-menor").hide()
            $("#"+contenedor_id).html(resp);
        }
    });

}

function alertError(title,msg){

    return Swal.fire({icon: 'error',
        title: title,
        text: msg,})
}
function alertExito(title,msg){
    return Swal.fire({icon: 'success',
        title: title,
        text: msg,})
}
function alertAdvertencia(title,msg){
    return Swal.fire({icon: 'warning',
        title: title,
        text: msg,})
}
function alertInfo(title,msg){
    return Swal.fire({icon: 'info',
        title: title,
        text: msg,})
}

function _ajax(url,method,data={},func) {
    $.ajax({
        type: method,
        url: _URL+url,
        data: data,
        success: function (resp) {
            $("#loader-menor").hide()
            if (isJson(resp)){
                func(JSON.parse(resp));
            }else{
                console.log(url)
                console.log(resp)
                alertError('ERR','Error en el servidor')
            }

        }
    });

}