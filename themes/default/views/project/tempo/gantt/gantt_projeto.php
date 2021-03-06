<?php 
 $this->load->view($this->theme . 'header_project_gantt', $meta);
?>

  

 
    
<div class="col-lg-12">
    <div class="box">


<div id="ndo" class="noprint">
  
</div>
<div id="workSpace" style="padding:0px; overflow-y:auto; overflow-x:hidden;border:1px solid #e5e5e5;position:relative;margin:0 5px"></div>

<style>
  .resEdit {
    padding: 15px;
  }

  .resLine {
    width: 95%;
    padding: 3px;
    margin: 5px;
    border: 1px solid #d0d0d0;
  }

  body {
    overflow: hidden;
  }

  .ganttButtonBar h1{
    color: #000000;
    font-weight: bold;
    font-size: 28px;
    margin-left: 10px;
  }

</style>

<form id="gimmeBack" style="display:none;" action="../gimmeBack.jsp" method="post" target="_blank"><input type="hidden" name="prj" id="gimBaPrj"></form>

<script type="text/javascript">

var ge;
$(function() {
  var canWrite=true; //this is the default for test purposes

  // here starts gantt initialization
  ge = new GanttMaster();
  ge.set100OnClose=true;

  ge.shrinkParent=true;

  ge.init($("#workSpace"));
  loadI18n(); //overwrite with localized ones

  //in order to force compute the best-fitting zoom level
  delete ge.gantt.zoom;

  var project=loadFromLocalStorage();

  if (!project.canWrite)
    $(".ganttButtonBar button.requireWrite").attr("disabled","true");

  ge.loadProject(project);
  ge.checkpoint(); //empty the undo stack
});



function getDemoProject(){
  //console.debug("getDemoProject")
ret= {"tasks":    [
      <?php
      $cont_seq_fase = 1;
      foreach ($fases as $fase) {
        $id_fase = $fase->fase_id;
        $nome_fase = $fase->nome_fase;
        
        $data_inicio = $fase->inicio;
        $partes_data = explode("-", $data_inicio);
        $ano2 = $partes_data[0];
        $mes2 = $partes_data[1];
        $dia2 = $partes_data[2];
        $data_inicio_tratado =   $dia2."-".$mes2."-".$ano2; 
        $milliseconds_data_inicio = 1000 * strtotime($data_inicio_tratado);
        //ECHO $milliseconds_data_inicio.'<BR>';
        
        $data_fim = $fase->fim;
        $partes_dataf = explode("-", $data_fim);
        $ano3 = $partes_dataf[0];
        $mes3 = $partes_dataf[1];
        $dia3 = $partes_dataf[2];
       // $data_fim_tratado = "29/04/2019";// $dia3."-".$mes3."-".$ano3;
        $data_fim_tratado2 =  $dia3."-".$mes3."-".$ano3;
        $milliseconds_data_fim = 1000 * strtotime($data_fim_tratado2);
       
        // ECHO $milliseconds_data_fim.'<BR>';
        //DIFERENÇA ENTRE DIAS
        
        $diferenca = strtotime($data_fim) - strtotime($data_inicio);
        $dias = floor($diferenca / (60 * 60 * 24));
        $dias = $dias + 1;
        
      ?>
      {"id": -<?php echo $id_fase; ?>, "name": "<?php echo $nome_fase; ?>", "progress": 20, "progressByWorklog": false, "relevance": 0, "type": "", "typeId": "", "description": "", "code": "Fase", "level": 0, "status": "STATUS_ACTIVE",    "depends": "",    "canWrite": true, "start": <?php echo $milliseconds_data_inicio; ?>, "duration": <?php echo $dias; ?>, "end": <?php echo $milliseconds_data_fim; ?>,   "collapsed": false, "assigs": [], "hasChild": true},
      
        <?php 
        // EVENTOS
        $cont_seq_evento = $cont_seq_fase + 1;
        if(!$idplano){
            $idplano = 0;
        }
        $eventos = $this->atas_model->getAllEventosProjeto($id_fase);
        foreach ($eventos as $evento) { 
        $id_evento = $evento->id;
        $nome_evento = $evento->nome_evento;
        $data_inicio_e = $evento->inicio;
        $partes_datae = explode("-", $data_inicio_e);
        $ano2e = $partes_datae[0];
        $mes2e = $partes_datae[1];
        $dia2e = $partes_datae[2];
        $data_inicio_tratadoe =   $dia2e."-".$mes2e."-".$ano2e; 
        $milliseconds_data_inicioe = 1000 * strtotime($data_inicio_tratadoe);
        //ECHO $milliseconds_data_inicio.'<BR>';
        
        $data_fim_e = $evento->fim;
        $partes_data_e = explode("-", $data_fim_e);
        $anoe = $partes_data_e[0];
        $mese = $partes_data_e[1];
        $diae = $partes_data_e[2];
       // $data_fim_tratado = "29/04/2019";// $dia3."-".$mes3."-".$ano3;
        $data_fim_tratadoe =  $diae."-".$mese."-".$anoe;
        $milliseconds_data_fim_e = 1000 * strtotime($data_fim_tratadoe);
       
        // ECHO $milliseconds_data_fim.'<BR>';
        //DIFERENÇA ENTRE DIAS
        
        $diferenca_e = strtotime($data_fim_e) - strtotime($data_inicio_e);
        $dias_e = floor($diferenca_e / (60 * 60 * 24));
        $dias_e = $dias_e + 1;
            
        ?>
          {"id": -<?php echo $id_fase.$id_evento; ?>, "name": "<?php echo $nome_evento; ?>",      "progress": 30, "progressByWorklog": false, "relevance": 0, "type": "", "typeId": "", "description": "", "code": "Evento", "level": 1, "status": "STATUS_SUSPENDED",    "depends": "",    "canWrite": true, "start": <?php echo $milliseconds_data_inicioe; ?>, "duration": <?php echo $dias_e; ?>, "end": <?php echo $milliseconds_data_fim_e; ?>,   "collapsed": false, "assigs": [], "hasChild": true},
    
         
         
         <?php 
        // ITENS EVENTOS
        $cont_seq_item_evento = $cont_seq_evento + 1;
        $itens = $this->atas_model->getAllItensEventosProjeto($id_evento);
        foreach ($itens as $item) { 
        $item_id = $item->id;
        $nome_item = $item->item;
        //DATA INICIO
        $data_inicio_i = $item->inicio;
        $partes_datai = explode("-", $data_inicio_i);
        $anoi = $partes_datai[0];
        $mesi = $partes_datai[1];
        $diai = $partes_datai[2];
        $data_inicio_tratadoi =   $diai."-".$mesi."-".$anoi; 
        $milliseconds_data_inicioi = 1000 * strtotime($data_inicio_tratadoi);
        //ECHO $milliseconds_data_inicio.'<BR>';
        
        $data_fim_i = $item->fim;
        $partes_data_i = explode("-", $data_fim_i);
        $anoii = $partes_data_i[0];
        $mesii = $partes_data_i[1];
        $diaii = $partes_data_i[2];
       // $data_fim_tratado = "29/04/2019";// $dia3."-".$mes3."-".$ano3;
        $data_fim_tratadoi =  $diaii."-".$mesii."-".$anoii;
        $milliseconds_data_fim_i = 1000 * strtotime($data_fim_tratadoi);
       
        // ECHO $milliseconds_data_fim.'<BR>';
        //DIFERENÇA ENTRE DIAS
        
        $diferenca_i = strtotime($data_fim_i) - strtotime($data_inicio_i);
        $dias_i = floor($diferenca_i / (60 * 60 * 24));
        $dias_i = $dias_i + 1;
            
        ?>
                {"id": -<?php echo $id_fase.$id_evento.$item_id; ?>, "name": "<?php echo $nome_item; ?>",      "progress": 30, "progressByWorklog": false, "relevance": 0, "type": "", "typeId": "", "description": "", "code": "Item", "level": 2, "status": "STATUS_DONE",    "depends": "",    "canWrite": true, "start": <?php echo $milliseconds_data_inicioi; ?>, "duration": <?php echo $dias_i; ?>, "end": <?php echo $milliseconds_data_fim_i; ?>,   "collapsed": false, "assigs": [], "hasChild": true},
   
                 <?php 
                // AÇÕES 
                 /*
                $cont_seq_acoes = $cont_seq_item_evento + 1;;
                $planos = $this->atas_model->getAllPlanosItensEventosPlano($idplano, $tipo, $item_id);
                foreach ($planos as $plano) { 
                $acao_id = $plano->idplanos;
                $nome_acao = strip_tags($plano->descricao);
                //DATA INICIO
                $data_inicio_acao = $plano->data_entrega_demanda;
                $partes_data_i_acao = explode("-", $data_inicio_acao);
                $anoia = $partes_data_i_acao[0];
                $mesia = $partes_data_i_acao[1];
                $diaia = $partes_data_i_acao[2];
                $data_inicio_tratadoia =   $diaia."-".$mesia."-".$anoia; 
                $milliseconds_data_inicioia = 1000 * strtotime($data_inicio_tratadoia);
                //ECHO $milliseconds_data_inicio.'<BR>';

                $data_fim_acao = $plano->data_termino;
                $partes_data_f_acao = explode("-", $data_fim_acao);
                $anoaa = $partes_data_f_acao[0];
                $mesaa = $partes_data_f_acao[1];
                $diaaa = $partes_data_f_acao[2];
               // $data_fim_tratado = "29/04/2019";// $dia3."-".$mes3."-".$ano3;
                $data_fim_tratado_acao =  $diaaa."-".$mesaa."-".$anoaa;
                $milliseconds_data_fim_acao = 1000 * strtotime($data_fim_tratado_acao);

                // ECHO $milliseconds_data_fim.'<BR>';
                //DIFERENÇA ENTRE DIAS

                $diferenca_acao = strtotime($data_fim_acao) - strtotime($data_inicio_acao);
                $dias_acao = floor($diferenca_acao / (60 * 60 * 24));
                $dias_acao = $dias_acao + 1;
                  * 
                  */

                ?>
              //  {"id": -<?php echo $id_fase.$id_evento.$item_id.$cont_seq_acoes; ?>, "name": "<?php echo $nome_acao; ?>",      "progress": 30, "progressByWorklog": false, "relevance": 0, "type": "", "typeId": "", "description": "", "code": "<?PHP echo $acao_id; ?>", "level": 3, "status": "STATUS_ACTIVE",    "depends": "",    "canWrite": true, "start": <?php echo $milliseconds_data_inicioia; ?>, "duration": <?php echo $dias_acao; ?>, "end": <?php echo $milliseconds_data_fim_acao; ?>,   "collapsed": false, "assigs": [], "hasChild": true},
   
         
           <?php //$cont_seq_acoes++;  } 
           //$cont_seq_item_evento = $cont_seq_acoes ;  //FIM AÇÕES  ?>
         
         
           <?php $cont_seq_item_evento++;  } $cont_seq_evento = $cont_seq_item_evento; $cont_seq_evento++; //FIM ITEM EVENTO ?>
         
        <?php  } $cont_seq_fase = $cont_seq_evento; $cont_seq_fase++; //FIM EVENTO ?>
     
    <?php } //FIM FASE ?>
          
      //{"id": -2, "name": "Cadastros",      "progress": 30, "progressByWorklog": false, "relevance": 0, "type": "", "typeId": "", "description": "", "code": "2", "level": 1, "status": "STATUS_ACTIVE",    "depends": "",    "canWrite": true, "start": 1396994400000, "duration": 10, "end": 1398203999999,   "collapsed": false, "assigs": [], "hasChild": true},
    //  {"id": -3, "name": "Escopo",         "progress": 40, "progressByWorklog": false, "relevance": 0, "type": "", "typeId": "", "description": "", "code": "3", "level": 2, "status": "STATUS_ACTIVE",    "depends": "",    "canWrite": true, "start": 1396994400000, "duration": 10,  "end": 1398203999999,   "collapsed": false, "assigs": [], "hasChild": false},
    //  {"id": -4, "name": "Fases",          "progress": 50, "progressByWorklog": false, "relevance": 0, "type": "", "typeId": "", "description": "", "code": "4", "level": 3, "status": "STATUS_SUSPENDED", "depends": "",    "canWrite": true, "start": 1396994400000, "duration": 2,  "end": 1397167199999,   "collapsed": false, "assigs": [], "hasChild": false},
    //  {"id": -5, "name": "testing",        "progress": 60, "progressByWorklog": false, "relevance": 0, "type": "", "typeId": "", "description": "", "code": "5", "level": 1, "status": "STATUS_SUSPENDED", "depends": "2:5", "canWrite": true, "start": 1398981600000, "duration": 5,  "end": 1399586399999,   "collapsed": false, "assigs": [], "hasChild": true},
    //  {"id": -6, "name": "test on safari", "progress": 10, "progressByWorklog": false, "relevance": 0, "type": "", "typeId": "", "description": "", "code": "6", "level": 2, "status": "STATUS_SUSPENDED", "depends": "",    "canWrite": true, "start": 1398981600000, "duration": 2,  "end": 1399327199999,   "collapsed": false, "assigs": [], "hasChild": false},
    //  {"id": -7, "name": "test on ie",     "progress": 20, "progressByWorklog": false, "relevance": 0, "type": "", "typeId": "", "description": "", "code": "7", "level": 2, "status": "STATUS_SUSPENDED", "depends": "6",   "canWrite": true, "start": 1399327200000, "duration": 3,  "end": 1399586399999,   "collapsed": false, "assigs": [], "hasChild": false},
    //  {"id": -8, "name": "test on chrome", "progress": 20, "progressByWorklog": false, "relevance": 0, "type": "", "typeId": "", "description": "", "code": "8", "level": 2, "status": "STATUS_SUSPENDED", "depends": "6",   "canWrite": true, "start": 1399327200000, "duration": 2,  "end": 1399499999999,   "collapsed": false, "assigs": [], "hasChild": false}
    ], "selectedRow": 2, "deletedTaskIds": [],
      "resources": [
      {"id": "tmp_1", "name": "Resource 1"},
      {"id": "tmp_2", "name": "Resource 2"},
      {"id": "tmp_3", "name": "Resource 3"},
      {"id": "tmp_4", "name": "Resource 4"}
    ],
      "roles": [
      {"id": "tmp_1", "name": "Project Manager"},
      {"id": "tmp_2", "name": "Worker"},
      {"id": "tmp_3", "name": "Stakeholder"},
      {"id": "tmp_4", "name": "Customer"}
    ], "canWrite":    true, "canDelete":true, "canWriteOnParent": true, canAdd:true}


   //actualize data
    //var offset=new Date().getTime()-ret.tasks[0].start;
    //for (var i=0;i<ret.tasks.length;i++) {
    //  ret.tasks[i].start = ret.tasks[i].start + offset;
   //}
  return ret;
}



function loadGanttFromServer(taskId, callback) {

  //this is a simulation: load data from the local storage if you have already played with the demo or a textarea with starting demo data
  var ret=loadFromLocalStorage();

  //this is the real implementation
  /*
  //var taskId = $("#taskSelector").val();
  var prof = new Profiler("loadServerSide");
  prof.reset();

  $.getJSON("ganttAjaxController.jsp", {CM:"LOADPROJECT",taskId:taskId}, function(response) {
    //console.debug(response);
    if (response.ok) {
      prof.stop();

      ge.loadProject(response.project);
      ge.checkpoint(); //empty the undo stack

      if (typeof(callback)=="function") {
        callback(response);
      }
    } else {
      jsonErrorHandling(response);
    }
  });
  */

  return ret;
}


function saveGanttOnServer() {

  //this is a simulation: save data to the local storage or to the textarea
  saveInLocalStorage();

  /*
  var prj = ge.saveProject();

  delete prj.resources;
  delete prj.roles;

  var prof = new Profiler("saveServerSide");
  prof.reset();

  if (ge.deletedTaskIds.length>0) {
    if (!confirm("TASK_THAT_WILL_BE_REMOVED\n"+ge.deletedTaskIds.length)) {
      return;
    }
  }

  $.ajax("ganttAjaxController.jsp", {
    dataType:"json",
    data: {CM:"SVPROJECT",prj:JSON.stringify(prj)},
    type:"POST",

    success: function(response) {
      if (response.ok) {
        prof.stop();
        if (response.project) {
          ge.loadProject(response.project); //must reload as "tmp_" ids are now the good ones
        } else {
          ge.reset();
        }
      } else {
        var errMsg="Errors saving project\n";
        if (response.message) {
          errMsg=errMsg+response.message+"\n";
        }

        if (response.errorMessages.length) {
          errMsg += response.errorMessages.join("\n");
        }

        alert(errMsg);
      }
    }

  });
  */
}

function newProject(){
  clearGantt();
}


function clearGantt() {
  ge.reset();
}

//-------------------------------------------  Get project file as JSON (used for migrate project from gantt to Teamwork) ------------------------------------------------------
function getFile() {
  $("#gimBaPrj").val(JSON.stringify(ge.saveProject()));
  $("#gimmeBack").submit();
  $("#gimBaPrj").val("");

  /*  var uriContent = "data:text/html;charset=utf-8," + encodeURIComponent(JSON.stringify(prj));
   neww=window.open(uriContent,"dl");*/
}


function loadFromLocalStorage() {
  var ret;
  if (localStorage) {
    if (localStorage.getObject("teamworkGantDemo")) {
      ret = localStorage.getObject("teamworkGantDemo");
    }
  }

  //if not found create a new example task
  if (!ret || !ret.tasks || ret.tasks.length == 0){
    ret=getDemoProject();
  }
  return ret;
}


function saveInLocalStorage() {
  var prj = ge.saveProject();
  if (localStorage) {
    localStorage.setObject("teamworkGantDemo", prj);
  }
}


//-------------------------------------------  Open a black popup for managing resources. This is only an axample of implementation (usually resources come from server) ------------------------------------------------------
function editResources(){

  //make resource editor
  var resourceEditor = $.JST.createFromTemplate({}, "RESOURCE_EDITOR");
  var resTbl=resourceEditor.find("#resourcesTable");

  for (var i=0;i<ge.resources.length;i++){
    var res=ge.resources[i];
    resTbl.append($.JST.createFromTemplate(res, "RESOURCE_ROW"))
  }


  //bind add resource
  resourceEditor.find("#addResource").click(function(){
    resTbl.append($.JST.createFromTemplate({id:"new",name:"resource"}, "RESOURCE_ROW"))
  });

  //bind save event
  resourceEditor.find("#resSaveButton").click(function(){
    var newRes=[];
    //find for deleted res
    for (var i=0;i<ge.resources.length;i++){
      var res=ge.resources[i];
      var row = resourceEditor.find("[resId="+res.id+"]");
      if (row.length>0){
        //if still there save it
        var name = row.find("input[name]").val();
        if (name && name!="")
          res.name=name;
        newRes.push(res);
      } else {
        //remove assignments
        for (var j=0;j<ge.tasks.length;j++){
          var task=ge.tasks[j];
          var newAss=[];
          for (var k=0;k<task.assigs.length;k++){
            var ass=task.assigs[k];
            if (ass.resourceId!=res.id)
              newAss.push(ass);
          }
          task.assigs=newAss;
        }
      }
    }

    //loop on new rows
    var cnt=0
    resourceEditor.find("[resId=new]").each(function(){
      cnt++;
      var row = $(this);
      var name = row.find("input[name]").val();
      if (name && name!="")
        newRes.push (new Resource("tmp_"+new Date().getTime()+"_"+cnt,name));
    });

    ge.resources=newRes;

    closeBlackPopup();
    ge.redraw();
  });


  var ndo = createModalPopup(400, 500).append(resourceEditor);
}

function initializeHistoryManagement(){

  //si chiede al server se c'è della hisory per la root
  $.getJSON(contextPath+"/applications/teamwork/task/taskAjaxController.jsp", {CM: "GETGANTTHISTPOINTS", OBJID:10236}, function (response) {

    //se c'è
    if (response.ok == true && response.historyPoints && response.historyPoints.length>0) {

      //si crea il bottone sulla bottoniera
      var histBtn = $("<button>").addClass("button textual icon lreq30 lreqLabel").attr("title", "SHOW_HISTORY").append("<span class=\"teamworkIcon\">&#x60;</span>");

      //al click
      histBtn .click(function () {
        var el = $(this);
        var ganttButtons = $(".ganttButtonBar .buttons");

        //è gi�  in modalit�  history?
        if (!ge.element.is(".historyOn")) {
          ge.element.addClass("historyOn");
          ganttButtons.find(".requireCanWrite").hide();

          //si carica la history server side
          if (false) return;
          showSavingMessage();
          $.getJSON(contextPath + "/applications/teamwork/task/taskAjaxController.jsp", {CM: "GETGANTTHISTPOINTS", OBJID: ge.tasks[0].id}, function (response) {
            jsonResponseHandling(response);
            hideSavingMessage();
            if (response.ok == true) {
              var dh = response.historyPoints;
              //ge.historyPoints=response.historyPoints;
              if (dh && dh.length > 0) {
                //si crea il div per lo slider
                var sliderDiv = $("<div>").prop("id", "slider").addClass("lreq30 lreqHide").css({"display":"inline-block","width":"500px"});
                ganttButtons.append(sliderDiv);

                var minVal = 0;
                var maxVal = dh.length-1 ;

                $("#slider").show().mbSlider({
                  rangeColor : '#2f97c6',
                  minVal     : minVal,
                  maxVal     : maxVal,
                  startAt    : maxVal,
                  showVal    : false,
                  grid       :1,
                  formatValue: function (val) {
                    return new Date(dh[val]).format();
                  },
                  onSlideLoad: function (obj) {
                    this.onStop(obj);

                  },
                  onStart    : function (obj) {},
                  onStop     : function (obj) {
                    var val = $(obj).mbgetVal();
                    showSavingMessage();
                    $.getJSON(contextPath + "/applications/teamwork/task/taskAjaxController.jsp", {CM: "GETGANTTHISTORYAT", OBJID: ge.tasks[0].id, millis:dh[val]}, function (response) {
                      jsonResponseHandling(response);
                      hideSavingMessage();
                      if (response.ok ) {
                        ge.baselines=response.baselines;
                        ge.showBaselines=true;
                        ge.baselineMillis=dh[val];
                        ge.redraw();
                      }
                    })

                  },
                  onSlide    : function (obj) {
                    clearTimeout(obj.renderHistory);
                    var self = this;
                    obj.renderHistory = setTimeout(function(){
                      self.onStop(obj);
                    }, 200)

                  }
                });
              }
            }
          });


          // quando si spenge
        } else {
          //si cancella lo slider
          $("#slider").remove();
          ge.element.removeClass("historyOn");
          if (ge.permissions.canWrite)
            ganttButtons.find(".requireCanWrite").show();

          ge.showBaselines=false;
          ge.baselineMillis=undefined;
          ge.redraw();
        }

      });
      $("#saveGanttButton").before(histBtn);
    }
  })
}

function showBaselineInfo (event,element){
  //alert(element.attr("data-label"));
  $(element).showBalloon(event, $(element).attr("data-label"));
  ge.splitter.secondBox.one("scroll",function(){
    $(element).hideBalloon();
  })
}

</script>



<div id="gantEditorTemplates" style="display:none;">
<div class="__template__" type="GANTBUTTONS">
    <?php
 $usuario = $this->session->userdata('user_id');                     
 $users_dados = $this->site->geUserByID($usuario);
 $modulo_atual = $users_dados->modulo_atual;

 $modulo_dados = $this->owner_model->getModuloById($modulo_atual);
 $controle = $modulo_dados->controle;
 $pagina_home = $modulo_dados->home;
 $logo_modulo = $modulo_dados->logo;
 
 if($logo_modulo){
     $logo_mod = $logo_modulo;
 }else{
  $logo_mod = 'sig.png';   
 }
 
?>
    <!--
  <div class="ganttButtonBar noprint">
    <div class="buttons">
  
    <a href="<?= site_url($pagina_home); ?>"><img alt="Twproject" align="absmiddle" style="max-width: 156px; padding-right: 15px" src="<?= base_url() ?>assets/uploads/logos/<?php echo $logo_mod; ?>" ></a>
   
    <span class="ganttButtonSeparator"></span>
      <button onclick="$('#workSpace').trigger('expandAll.gantt');return false;" class="button textual icon " title="EXPAND_ALL"><span class="teamworkIcon">6</span></button>
      <button onclick="$('#workSpace').trigger('collapseAll.gantt'); return false;" class="button textual icon " title="COLLAPSE_ALL"><span class="teamworkIcon">5</span></button>

    <span class="ganttButtonSeparator"></span>
      <button onclick="$('#workSpace').trigger('zoomMinus.gantt'); return false;" class="button textual icon " title="zoom out"><span class="teamworkIcon">)</span></button>
      <button onclick="$('#workSpace').trigger('zoomPlus.gantt');return false;" class="button textual icon " title="zoom in"><span class="teamworkIcon">(</span></button>
    <span class="ganttButtonSeparator"></span>
      <button onclick="$('#workSpace').trigger('print.gantt');return false;" class="button textual icon " title="Print"><span class="teamworkIcon">p</span></button>
    <span class="ganttButtonSeparator"></span>
      <button onclick="ge.gantt.showCriticalPath=!ge.gantt.showCriticalPath; ge.redraw();return false;" class="button textual icon requireCanSeeCriticalPath" title="CRITICAL_PATH"><span class="teamworkIcon">&pound;</span></button>
    <span class="ganttButtonSeparator requireCanSeeCriticalPath"></span>
      <button onclick="ge.splitter.resize(.1);return false;" class="button textual icon" ><span class="teamworkIcon">F</span></button>
      <button onclick="ge.splitter.resize(50);return false;" class="button textual icon" ><span class="teamworkIcon">O</span></button>
      <button onclick="ge.splitter.resize(100);return false;" class="button textual icon"><span class="teamworkIcon">R</span></button>
      <span class="ganttButtonSeparator"></span>
     
    
      &nbsp; &nbsp; &nbsp; &nbsp;
    <button class="button login" title="login/enroll" onclick="loginEnroll($(this));" style="display:none;">login/enroll</button>
    <button class="button opt collab" title="Start with Twproject" onclick="collaborate($(this));" style="display:none;"><em>collaborate</em></button>
    </div></div>
  --></div>

<div class="__template__" type="TASKSEDITHEAD">
  <table class="gdfTable" cellspacing="0" cellpadding="0">
    <thead>
    <tr style="height:40px">
      <th class="gdfColHeader" style="width:35px; border-right: none"></th>
      <th class="gdfColHeader" style="width:25px;"></th>
      <th class="gdfColHeader gdfResizable" style="width:50px;">Nível</th> 
      <th class="gdfColHeader gdfResizable" style="width:300px;">Escopo</th>
                                              
      <th class="gdfColHeader"  align="center" style="width:17px;" title="Start date is a milestone."><span class="teamworkIcon" style="font-size: 8px;">^</span></th>
      <th class="gdfColHeader gdfResizable" style="width:80px;">Início</th>
      <th class="gdfColHeader"  align="center" style="width:17px;" title="End date is a milestone."><span class="teamworkIcon" style="font-size: 8px;">^</span></th>
      <th class="gdfColHeader gdfResizable" style="width:80px;">Fim</th>
      <th class="gdfColHeader gdfResizable" style="width:50px;">Dias</th>
      <th class="gdfColHeader gdfResizable" style="width:20px;">%</th>
      <th class="gdfColHeader gdfResizable requireCanSeeDep" style="width:50px;">depe.</th>
      <th class="gdfColHeader gdfResizable" style="width:100px; text-align: left; padding-left: 10px;">Responsável</th>
    </tr>
    </thead>
  </table>
  </div>

<div class="__template__" type="TASKROW"><!--
  <tr id="tid_(#=obj.id#)" taskId="(#=obj.id#)" class="taskEditRow (#=obj.isParent()?'isParent':''#) (#=obj.collapsed?'collapsed':''#)" level="(#=level#)">
    <th class="gdfCell edit" align="right" style="cursor:pointer;"><span class="taskRowIndex">(#=obj.getRow()+1#)</span> <span class="teamworkIcon" style="font-size:12px;" >e</span></th>
    <td class="gdfCell noClip" align="center"><div class="taskStatus cvcColorSquare" status="(#=obj.status#)"></div></td>
    <td class="gdfCell"><input type="text" name="code" value="(#=obj.code?obj.code:''#)" ></td>
    <td class="gdfCell indentCell" style="padding-left:(#=obj.level*10+18#)px;">
      <div class="exp-controller" align="center"></div>
      <input type="text" name="name" value="(#=obj.name#)" placeholder="Escopo">
    </td>
    
    <td class="gdfCell" align="center"></td>
    <td class="gdfCell"><input type="text" name="start"  value="" class="date"></td>
    <td class="gdfCell" align="center"></td>
    <td class="gdfCell"><input type="text" name="end" value="" class="date"></td>
    <td class="gdfCell"><input type="text" name="duration" autocomplete="off" value="(#=obj.duration#)"></td>
    <td class="gdfCell"><input type="text" name="progress" class="validated" entrytype="PERCENTILE" autocomplete="off" value="(#=obj.progress?obj.progress:''#)" (#=obj.progressByWorklog?"readOnly":""#)></td>
    <td class="gdfCell requireCanSeeDep"><input type="text" name="depends" autocomplete="off" value="(#=obj.depends#)" (#=obj.hasExternalDep?"readonly":""#)></td>
    <td class="gdfCell taskAssigs">(#=obj.getAssigsString()#)</td>
  </tr>
  --></div>



<div class="__template__" type="TASKBAR"><!--
  <div class="taskBox taskBoxDiv" taskId="(#=obj.id#)" >
    <div class="layout (#=obj.hasExternalDep?'extDep':''#)">
      <div class="taskStatus" status="(#=obj.status#)"></div>
      <div class="taskProgress" style="width:(#=obj.progress>100?100:obj.progress#)%; background-color:(#=obj.progress>100?'red':'rgb(153,255,51);'#);"></div>
      <div class="milestone (#=obj.startIsMilestone?'active':''#)" ></div>

      <div class="taskLabel"></div>
      <div class="milestone end (#=obj.endIsMilestone?'active':''#)" ></div>
    </div>
  </div>
  --></div>


<div class="__template__" type="CHANGE_STATUS"><!--
    <div class="taskStatusBox">
    <div class="taskStatus cvcColorSquare" status="STATUS_ACTIVE" title="Active"></div>
    <div class="taskStatus cvcColorSquare" status="STATUS_DONE" title="Completed"></div>
    <div class="taskStatus cvcColorSquare" status="STATUS_FAILED" title="Failed"></div>
    <div class="taskStatus cvcColorSquare" status="STATUS_SUSPENDED" title="Suspended"></div>
    <div class="taskStatus cvcColorSquare" status="STATUS_WAITING" title="Waiting" style="display: none;"></div>
    <div class="taskStatus cvcColorSquare" status="STATUS_UNDEFINED" title="Undefined"></div>
    </div>
  --></div>




<div class="__template__" type="TASK_EDITOR"><!--
  <div class="ganttTaskEditor">
    <h2 class="taskData">Task editor</h2>
    <table  cellspacing="1" cellpadding="5" width="100%" class="taskData table" border="0">
          <tr>
        <td width="200" style="height: 80px"  valign="top">
          <label for="code">code/short name</label><br>
          <input type="text" name="code" id="code" value="" size=15 class="formElements" autocomplete='off' maxlength=255 style='width:100%' oldvalue="1">
        </td>
        <td colspan="3" valign="top"><label for="name" class="required">name</label><br><input type="text" name="name" id="name"class="formElements" autocomplete='off' maxlength=255 style='width:100%' value="" required="true" oldvalue="1"></td>
          </tr>


      <tr class="dateRow">
        <td nowrap="">
          <div style="position:relative">
            <label for="start">start</label>&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="checkbox" id="startIsMilestone" name="startIsMilestone" value="yes"> &nbsp;<label for="startIsMilestone">is milestone</label>&nbsp;
            <br><input type="text" name="start" id="start" size="8" class="formElements dateField validated date" autocomplete="off" maxlength="255" value="" oldvalue="1" entrytype="DATE">
            <span title="calendar" id="starts_inputDate" class="teamworkIcon openCalendar" onclick="$(this).dateField({inputField:$(this).prevAll(':input:first'),isSearchField:false});">m</span>          </div>
        </td>
        <td nowrap="">
          <label for="end">End</label>&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="checkbox" id="endIsMilestone" name="endIsMilestone" value="yes"> &nbsp;<label for="endIsMilestone">is milestone</label>&nbsp;
          <br><input type="text" name="end" id="end" size="8" class="formElements dateField validated date" autocomplete="off" maxlength="255" value="" oldvalue="1" entrytype="DATE">
          <span title="calendar" id="ends_inputDate" class="teamworkIcon openCalendar" onclick="$(this).dateField({inputField:$(this).prevAll(':input:first'),isSearchField:false});">m</span>
        </td>
        <td nowrap="" >
          <label for="duration" class=" ">Days</label><br>
          <input type="text" name="duration" id="duration" size="4" class="formElements validated durationdays" title="Duration is in working days." autocomplete="off" maxlength="255" value="" oldvalue="1" entrytype="DURATIONDAYS">&nbsp;
        </td>
      </tr>

      <tr>
        <td  colspan="2">
          <label for="status" class=" ">status</label><br>
          <select id="status" name="status" class="taskStatus" status="(#=obj.status#)"  onchange="$(this).attr('STATUS',$(this).val());">
            <option value="STATUS_ACTIVE" class="taskStatus" status="STATUS_ACTIVE" >active</option>
            <option value="STATUS_WAITING" class="taskStatus" status="STATUS_WAITING" >suspended</option>
            <option value="STATUS_SUSPENDED" class="taskStatus" status="STATUS_SUSPENDED" >suspended</option>
            <option value="STATUS_DONE" class="taskStatus" status="STATUS_DONE" >completed</option>
            <option value="STATUS_FAILED" class="taskStatus" status="STATUS_FAILED" >failed</option>
            <option value="STATUS_UNDEFINED" class="taskStatus" status="STATUS_UNDEFINED" >undefined</option>
          </select>
        </td>

        <td valign="top" nowrap>
          <label>progress</label><br>
          <input type="text" name="progress" id="progress" size="7" class="formElements validated percentile" autocomplete="off" maxlength="255" value="" oldvalue="1" entrytype="PERCENTILE">
        </td>
      </tr>

          </tr>
          <tr>
            <td colspan="4">
              <label for="description">Description</label><br>
              <textarea rows="3" cols="30" id="description" name="description" class="formElements" style="width:100%"></textarea>
            </td>
          </tr>
        </table>

    <h2>Assignments</h2>
  <table  cellspacing="1" cellpadding="0" width="100%" id="assigsTable">
    <tr>
      <th style="width:100px;">name</th>
      <th style="width:70px;">Role</th>
      <th style="width:30px;">est.wklg.</th>
      <th style="width:30px;" id="addAssig"><span class="teamworkIcon" style="cursor: pointer">+</span></th>
    </tr>
  </table>

  <div style="text-align: right; padding-top: 20px">
    <span id="saveButton" class="button first" onClick="$(this).trigger('saveFullEditor.gantt');">Save</span>
  </div>

  </div>
  --></div>



<div class="__template__" type="ASSIGNMENT_ROW"><!--
  <tr taskId="(#=obj.task.id#)" assId="(#=obj.assig.id#)" class="assigEditRow" >
    <td ><select name="resourceId"  class="formElements" (#=obj.assig.id.indexOf("tmp_")==0?"":"disabled"#) ></select></td>
    <td ><select type="select" name="roleId"  class="formElements"></select></td>
    <td ><input type="text" name="effort" value="(#=getMillisInHoursMinutes(obj.assig.effort)#)" size="5" class="formElements"></td>
    <td align="center"><span class="teamworkIcon delAssig del" style="cursor: pointer">d</span></td>
  </tr>
  --></div>



<div class="__template__" type="RESOURCE_EDITOR"><!--
  <div class="resourceEditor" style="padding: 5px;">

    <h2>Project team</h2>
    <table  cellspacing="1" cellpadding="0" width="100%" id="resourcesTable">
      <tr>
        <th style="width:100px;">name</th>
        <th style="width:30px;" id="addResource"><span class="teamworkIcon" style="cursor: pointer">+</span></th>
      </tr>
    </table>

    <div style="text-align: right; padding-top: 20px"><button id="resSaveButton" class="button big">Save</button></div>
  </div>
  --></div>



<div class="__template__" type="RESOURCE_ROW"><!--
  <tr resId="(#=obj.id#)" class="resRow" >
    <td ><input type="text" name="name" value="(#=obj.name#)" style="width:100%;" class="formElements"></td>
    <td align="center"><span class="teamworkIcon delRes del" style="cursor: pointer">d</span></td>
  </tr>
  --></div>


</div>
<script type="text/javascript">
  $.JST.loadDecorator("RESOURCE_ROW", function(resTr, res){
    resTr.find(".delRes").click(function(){$(this).closest("tr").remove()});
  });

  $.JST.loadDecorator("ASSIGNMENT_ROW", function(assigTr, taskAssig){
    var resEl = assigTr.find("[name=resourceId]");
    var opt = $("<option>");
    resEl.append(opt);
    for(var i=0; i< taskAssig.task.master.resources.length;i++){
      var res = taskAssig.task.master.resources[i];
      opt = $("<option>");
      opt.val(res.id).html(res.name);
      if(taskAssig.assig.resourceId == res.id)
        opt.attr("selected", "true");
      resEl.append(opt);
    }
    var roleEl = assigTr.find("[name=roleId]");
    for(var i=0; i< taskAssig.task.master.roles.length;i++){
      var role = taskAssig.task.master.roles[i];
      var optr = $("<option>");
      optr.val(role.id).html(role.name);
      if(taskAssig.assig.roleId == role.id)
        optr.attr("selected", "true");
      roleEl.append(optr);
    }

    if(taskAssig.task.master.permissions.canWrite && taskAssig.task.canWrite){
      assigTr.find(".delAssig").click(function(){
        var tr = $(this).closest("[assId]").fadeOut(200, function(){$(this).remove()});
      });
    }

  });


  function loadI18n(){
    GanttMaster.messages = {
      "CANNOT_WRITE":"No permission to change the following task:",
      "CHANGE_OUT_OF_SCOPE":"Project update not possible as you lack rights for updating a parent project.",
      "START_IS_MILESTONE":"Start date is a milestone.",
      "END_IS_MILESTONE":"End date is a milestone.",
      "TASK_HAS_CONSTRAINTS":"Task has constraints.",
      "GANTT_ERROR_DEPENDS_ON_OPEN_TASK":"Error: there is a dependency on an open task.",
      "GANTT_ERROR_DESCENDANT_OF_CLOSED_TASK":"Error: due to a descendant of a closed task.",
      "TASK_HAS_EXTERNAL_DEPS":"This task has external dependencies.",
      "GANNT_ERROR_LOADING_DATA_TASK_REMOVED":"GANNT_ERROR_LOADING_DATA_TASK_REMOVED",
      "CIRCULAR_REFERENCE":"Circular reference.",
      "CANNOT_DEPENDS_ON_ANCESTORS":"Cannot depend on ancestors.",
      "INVALID_DATE_FORMAT":"The data inserted are invalid for the field format.",
      "GANTT_ERROR_LOADING_DATA_TASK_REMOVED":"An error has occurred while loading the data. A task has been trashed.",
      "CANNOT_CLOSE_TASK_IF_OPEN_ISSUE":"Cannot close a task with open issues",
      "TASK_MOVE_INCONSISTENT_LEVEL":"You cannot exchange tasks of different depth.",
      "CANNOT_MOVE_TASK":"CANNOT_MOVE_TASK",
      "PLEASE_SAVE_PROJECT":"PLEASE_SAVE_PROJECT",
      "GANTT_SEMESTER":"Semester",
      "GANTT_SEMESTER_SHORT":"s.",
      "GANTT_QUARTER":"Quarter",
      "GANTT_QUARTER_SHORT":"q.",
      "GANTT_WEEK":"Week",
      "GANTT_WEEK_SHORT":"w."
    };
  }



  function createNewResource(el) {
    var row = el.closest("tr[taskid]");
    var name = row.find("[name=resourceId_txt]").val();
    var url = contextPath + "/applications/teamwork/resource/resourceNew.jsp?CM=ADD&name=" + encodeURI(name);

    openBlackPopup(url, 700, 320, function (response) {
      //fillare lo smart combo
      if (response && response.resId && response.resName) {
        //fillare lo smart combo e chiudere l'editor
        row.find("[name=resourceId]").val(response.resId);
        row.find("[name=resourceId_txt]").val(response.resName).focus().blur();
      }

    });
  }
</script>


    </div>        
</div>
   
     

</body>
</html>