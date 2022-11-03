<?php
   /**
    * Plugin Name: Calculador de Impacto Ambiental 1.0
    * Description: Este plugin calcula el impacto ambiental
    * Version: 1.0.0
    * Author: Manuel Jesús Aguair Gámez
    * License: GPL2
    */


   if(!defined('ABSPATH')) die();

   define("TEST_DIR", __FILE__);
   define("TEST_PLUGIN_DIR", plugin_dir_path(TEST_DIR));
   define("TEST_PLUGIN_URL", plugin_dir_url(TEST_DIR));

   require_once TEST_PLUGIN_DIR."includes/classes/main.php";
   require_once TEST_PLUGIN_DIR."includes/classes/main.php";
   $main = new main;

   register_activation_hook( TEST_DIR, [$main, 'activate'] );
   register_deactivation_hook( TEST_DIR, [$main, 'deactivate'] );

   //Add plugin css
   function myPluginCss(){
      //Bootstrap
      wp_register_style('bootstrapcss', TEST_PLUGIN_URL."public/css/bootstrap.min.css");
      wp_enqueue_style('bootstrapcss');

      wp_register_style('font-awesomecss', TEST_PLUGIN_URL."public/css/font-awesome.css");
      wp_enqueue_style('font-awesomecss');

      //Plugin
      wp_register_style('wizardcss', TEST_PLUGIN_URL."public/css/wizard.css");
      wp_enqueue_style('wizardcss');

      wp_register_style('rounded-radio', TEST_PLUGIN_URL."public/css/rounded-radio.css");
      wp_enqueue_style('rounded-radio');

      wp_register_style('circular-meter', TEST_PLUGIN_URL."public/css/circular-meter.css");
      wp_enqueue_style('circular-meter');
   }

   // Add plugin scripts
   function myPluginScripts(){
      //Bootstrap
      wp_register_script( 'bootstrapjs', TEST_PLUGIN_URL."public/js/bootstrap.bundle.min.js");
      wp_enqueue_script('bootstrapjs');

      //Jquery
      wp_register_script( 'jqueryjs', TEST_PLUGIN_URL. "public/js/jquery.min.js");
      wp_enqueue_script('jqueryjs');

      //Plugin
      wp_register_script( 'wizardjs', TEST_PLUGIN_URL."public/js/wizard.js");
      wp_enqueue_script('wizardjs');

      wp_register_script( 'raphaeljs', TEST_PLUGIN_URL."public/js/raphael.min.js");
      wp_enqueue_script('raphaeljs');    

      wp_register_script( 'justgagejs', TEST_PLUGIN_URL."public/js/justgage.js");
      wp_enqueue_script('justgagejs'); 
      
   }

   add_action('wp_enqueue_scripts', 'myPluginCss', 999);
   add_action('wp_enqueue_scripts', 'myPluginScripts', 999);

   add_shortcode('carbon-foot', 'myForm');

   function questionOne($language="COL"){

        $question= [
            "COL" => "¿Cuantas personas más viven en tu casa?",
            "MEX" => "¿Cuantas personas más viven en tu casa?",
            "USA" => "How many other people live in your household?"            
        ];

        ?>
            <div class="row">
                <div class="col-6">
                    <img src="<?php echo TEST_PLUGIN_URL.'public/images/1.png'; ?>" width="80%">
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="fs-title">1. <?php echo $question[$language]; ?></h2>
                        </div>
                    </div>
                    <div class="price-box">

                    <div id="slider"></div>

                    </div>
                    <div class="options">                
                        <?php
                            for($i=1; $i<8; $i++){
                                ?>
                                <label class="relative mb-6 lg:mb-0" data-v-05d2fc82="">
                                    <input type="radio" class="hidden peer" name="questionOne"  data-type="int" value="<?php echo $i; ?>" data-v-05d2fc82="">
                                    <div class="flex items-center justify-between cursor-pointer square"  data-v-05d2fc82=""><?php echo $i; ?></div>
                                </label>
                                <?php
                            }
                        ?>
                    </div>                    
                </div>
            </div>
        <?php
   }

   function questionTwo($language="COL"){

    $question= [
        "COL" => "¿Cuánto pagas al mes por los servicios públicos? ($ COP)",
        "MEX" => "¿Cuánto pagas al mes por los servicios públicos? ($ COP)",
        "USA" => "How many other people live in your household?"            
    ];

    ?>
        <div class="row">
            <div class="col-6">
                <img src="<?php echo TEST_PLUGIN_URL.'public/images/2.png'; ?>" width="80%">
            </div>
            <div class="col-6">
                <div class="row">
                    <div class="col-12">
                        <h2 class="fs-title">2. <?php echo $question[$language]; ?></h2>
                    </div>
                </div>

                <label class="fieldlabels">Electricidad: </label> <output id="outputElect">0</output> $ COP  <br>
               
                <input type="range" value="0" min="0" max="1000" oninput="document.getElementById('outputElect').value = this.value">
                    
                <label class="fieldlabels">Gas: </label> <output id="outputGas">0</output> $ COP  <br>
               
                <input type="range" value="0" min="0" max="1000" oninput="document.getElementById('outputGas').value = this.value"> 

                
            </div>
        </div>
    <?php
}

   function myForm($atts){

      ?>

<div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-11 col-sm-11 col-md-11 col-lg-11 col-xl-11 text-center p-0 mt-3 mb-2">
                <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                    <!-- <h2 id="heading">Mide tu impacto ambiental</h2> -->
    
                    <form id="msform" class="form-pricing">
    
                        <ul id="progressbar">
                            <li class="active" id="house"><strong>Vivienda</strong></li>
                            <li id="receipt"><strong>Servicios</strong></li>
                            <li id="car"><strong>Transporte</strong></li>
                            <li id="plane"><strong>Vuelos</strong></li>
                            <li id="meat"><strong>Alimentación</strong></li>
                            <li id="confirm"><strong>Resultado</strong></li>
                        </ul>


       
                        <fieldset>
                            <div class="form-card">
                                <div class="col-12">
                                    <?php questionOne(); ?>
                                </div>
                            </div>
                            <input type="button" name="next" class="next action-button" value="Siguiente"/>
                        </fieldset>

                        <fieldset>
                            <div class="form-card">
                                <div class="col-12">
                                    <?php questionTwo(); ?>
                                </div>
                            </div>
                            <input type="button" name="next" class="next action-button" value="Siguiente"/>
                            <input type="button" name="previous" class="previous action-button-previous" value="Regresar"/>
                        </fieldset> 

                    



                        <fieldset>
                            <div class="form-card">



                            <div class="row">
                                    <div class="col-6">
                                        <img src="img/3.png" width="80%">
                                    </div>
                                    <div class="col-6">

                                        <div class="row">
                                            <div class="col-12">
                                                <h2 class="fs-title">3. Selecciona el medio de transporte que usas: </h2>
                                            </div>

                                        </div>

                                        <div class="funkyradio">


                                            <div class="funkyradio-primary">
                                                <input type="checkbox" name="checkbox" id="checkbox1" />
                                                <label for="checkbox1">Auto</label>
                                            </div>
                                            <div class="funkyradio-primary">
                                                <input type="checkbox" name="checkbox" id="checkbox2" />
                                                <label for="checkbox2">Taxi</label>
                                            </div>
                                            <div class="funkyradio-primary">
                                                <input type="checkbox" name="checkbox" id="checkbox3" />
                                                <label for="checkbox3">Motocicleta</label>
                                            </div>
                                            <div class="funkyradio-primary">
                                                <input type="checkbox" name="checkbox" id="checkbox4" />
                                                <label for="checkbox4">Bicileta</label>
                                            </div>
                                            <div class="funkyradio-primary">
                                                <input type="checkbox" name="checkbox" id="checkbox5" />
                                                <label for="checkbox5">Scooter</label>
                                            </div>
                                            <div class="funkyradio-primary">
                                                <input type="checkbox" name="checkbox" id="checkbox6" />
                                                <label for="checkbox6">Transporte publico</label>
                                            </div>
                                            <div class="funkyradio-primary">
                                                <input type="checkbox" name="checkbox" id="checkbox6" />
                                                <label for="checkbox7">Ninguno</label>
                                            </div>        
                                            
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <input type="button" name="next" class="next action-button" value="Siguiente"/>
                            <input type="button" name="previous" class="previous action-button-previous" value="Regresar"/>
                        </fieldset>

                        <fieldset>
                            <div class="form-card">

                                <div class="row">
                                    <div class="col-6">
                                        <img src="img/4.png" width="60%">
                                    </div>
                                    <div class="col-6">

                                        <div class="row">
                                            <div class="col-12">
                                                <h2 class="fs-title">4. Cantidad de vuelos que realizas al año:</h2>
                                            </div>

                                        </div>

                                        <div class="funkyradio">
                                            <div class="funkyradio-primary">
                                                <input type="radio" name="radio" id="radio1"/>
                                                <label for="radio1">Menos de 2</label>
                                            </div>
                                            <div class="funkyradio-primary">
                                                <input type="radio" name="radio" id="radio2" />
                                                <label for="radio2">Entre 2 a 5 </label>
                                            </div>
                                            <div class="funkyradio-primary">
                                                <input type="radio" name="radio" id="radio2" />
                                                <label for="radio2">Entre 5 a 7 </label>
                                            </div>
                                            <div class="funkyradio-primary">
                                                <input type="radio" name="radio" id="radio3" />
                                                <label for="radio3">Mas 7</label>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <input type="button" name="next" class="next action-button" value="Siguiente"/>
                        <input type="button" name="previous" class="previous action-button-previous" value="Regresar"/>

                        </fieldset> 
                        
                        
                        <fieldset>
                            <div class="form-card">

                            <div class="row">
                                <div class="col-6">
                                    <img src="img/5.png" width="60%">
                                </div>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-7">
                                            <h2 class="fs-title">5. Cuantas veces a la semana consumes:</h2>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-7">
                                            <h5>a) Carne roja</h5>
                                        </div>
                                    </div>
                                    
            
                                    <label class="relative mb-6 lg:mb-0" data-v-05d2fc82="">                                    
                                                <input class="hidden peer" name="adults-n" type="radio" data-type="int" value="1" data-v-05d2fc82="">

                                                <div class="flex items-center justify-between cursor-pointer square  " id="adults-n" data-v-05d2fc82="">1 <!--v-if--></div>

                                            </label>
                                                                                        <label class="relative mb-6 lg:mb-0" data-v-05d2fc82="">                                    
                                                <input class="hidden peer" name="adults-n" type="radio" data-type="int" value="2" data-v-05d2fc82="">

                                                <div class="flex items-center justify-between cursor-pointer square  " id="adults-n" data-v-05d2fc82="">2 <!--v-if--></div>

                                            </label>
                                                                                        <label class="relative mb-6 lg:mb-0" data-v-05d2fc82="">                                    
                                                <input class="hidden peer" name="adults-n" type="radio" data-type="int" value="3" data-v-05d2fc82="">

                                                <div class="flex items-center justify-between cursor-pointer square  " id="adults-n" data-v-05d2fc82="">3 <!--v-if--></div>

                                            </label>
                                                                                        <label class="relative mb-6 lg:mb-0" data-v-05d2fc82="">                                    
                                                <input class="hidden peer" name="adults-n" type="radio" data-type="int" value="4" data-v-05d2fc82="">

                                                <div class="flex items-center justify-between cursor-pointer square  " id="adults-n" data-v-05d2fc82="">4 <!--v-if--></div>

                                            </label>
                                                                                        <label class="relative mb-6 lg:mb-0" data-v-05d2fc82="">                                    
                                                <input class="hidden peer" name="adults-n" type="radio" data-type="int" value="5" data-v-05d2fc82="">

                                                <div class="flex items-center justify-between cursor-pointer square  " id="adults-n" data-v-05d2fc82="">5 <!--v-if--></div>

                                            </label>
                                                                                        <label class="relative mb-6 lg:mb-0" data-v-05d2fc82="">                                    
                                                <input class="hidden peer" name="adults-n" type="radio" data-type="int" value="6" data-v-05d2fc82="">

                                                <div class="flex items-center justify-between cursor-pointer square  " id="adults-n" data-v-05d2fc82="">6 <!--v-if--></div>

                                            </label>
                                                                                        <label class="relative mb-6 lg:mb-0" data-v-05d2fc82="">                                    
                                                <input class="hidden peer" name="adults-n" type="radio" data-type="int" value="7" data-v-05d2fc82="">

                                                <div class="flex items-center justify-between cursor-pointer square  " id="adults-n" data-v-05d2fc82="">7 <!--v-if--></div>

                                            </label>
                                                                                        <label class="relative mb-6 lg:mb-0" data-v-05d2fc82="">                                    
                                                <input class="hidden peer" name="adults-n" type="radio" data-type="int" value="8" data-v-05d2fc82="">

                                                <div class="flex items-center justify-between cursor-pointer square  " id="adults-n" data-v-05d2fc82="">8 <!--v-if--></div>

                                            </label>

                                <div class="row">
                                        <div class="col-7">
                                            <h5>b) Comida vegetariana</h5>
                                        </div>
                                    </div>
                                    
            
                                    <label class="relative mb-6 lg:mb-0" data-v-05d2fc82="">                                    
                                                <input class="hidden peer" name="adults-n" type="radio" data-type="int" value="1" data-v-05d2fc82="">

                                                <div class="flex items-center justify-between cursor-pointer square  " id="adults-n" data-v-05d2fc82="">1 <!--v-if--></div>

                                            </label>
                                                                                        <label class="relative mb-6 lg:mb-0" data-v-05d2fc82="">                                    
                                                <input class="hidden peer" name="adults-n" type="radio" data-type="int" value="2" data-v-05d2fc82="">

                                                <div class="flex items-center justify-between cursor-pointer square  " id="adults-n" data-v-05d2fc82="">2 <!--v-if--></div>

                                            </label>
                                                                                        <label class="relative mb-6 lg:mb-0" data-v-05d2fc82="">                                    
                                                <input class="hidden peer" name="adults-n" type="radio" data-type="int" value="3" data-v-05d2fc82="">

                                                <div class="flex items-center justify-between cursor-pointer square  " id="adults-n" data-v-05d2fc82="">3 <!--v-if--></div>

                                            </label>
                                                                                        <label class="relative mb-6 lg:mb-0" data-v-05d2fc82="">                                    
                                                <input class="hidden peer" name="adults-n" type="radio" data-type="int" value="4" data-v-05d2fc82="">

                                                <div class="flex items-center justify-between cursor-pointer square  " id="adults-n" data-v-05d2fc82="">4 <!--v-if--></div>

                                            </label>
                                                                                        <label class="relative mb-6 lg:mb-0" data-v-05d2fc82="">                                    
                                                <input class="hidden peer" name="adults-n" type="radio" data-type="int" value="5" data-v-05d2fc82="">

                                                <div class="flex items-center justify-between cursor-pointer square  " id="adults-n" data-v-05d2fc82="">5 <!--v-if--></div>

                                            </label>
                                                                                        <label class="relative mb-6 lg:mb-0" data-v-05d2fc82="">                                    
                                                <input class="hidden peer" name="adults-n" type="radio" data-type="int" value="6" data-v-05d2fc82="">

                                                <div class="flex items-center justify-between cursor-pointer square  " id="adults-n" data-v-05d2fc82="">6 <!--v-if--></div>

                                            </label>
                                                                                        <label class="relative mb-6 lg:mb-0" data-v-05d2fc82="">                                    
                                                <input class="hidden peer" name="adults-n" type="radio" data-type="int" value="7" data-v-05d2fc82="">

                                                <div class="flex items-center justify-between cursor-pointer square  " id="adults-n" data-v-05d2fc82="">7 <!--v-if--></div>

                                            </label>
                                                                                        <label class="relative mb-6 lg:mb-0" data-v-05d2fc82="">                                    
                                                <input class="hidden peer" name="adults-n" type="radio" data-type="int" value="8" data-v-05d2fc82="">

                                                <div class="flex items-center justify-between cursor-pointer square  " id="adults-n" data-v-05d2fc82="">8 <!--v-if--></div>

                                            </label>
                                 
                                 
                                </div>

                            </div>




                            </div>
                            <input type="button" name="next" class="next action-button" value="Finalizar"/>
                            <input type="button" name="previous" class="previous action-button-previous" value="Regresar"/>
                        </fieldset>                       



                        <fieldset>
                            <div class="form-card">
                                <div class="row">
                                    <div class="col-12">
                                        <h2 class="fs-title">Resultados:</h2>
                                    </div>
                                </div>
                                <br><br>

                                <h2 class="col-12 text-center">Tu huella de carbono anual es dee:</h2>
                                <br>
                                <div class="row text-center">
                                    <div class="col-12">
                                    
                                        <div id="gauge"></div>

                                        <h1 text-center"><strong>1.3 toneladas</strong></h2>
                                    </div>
                                </div>
                                <br><br>
                                <div class="row justify-content-center">
                                    <div class="col-12 text-center">
                                        <p>Tu huella de carbono anual es 79% menor que el promedio de México y 85% menor que el promedio mundial.</p>
                                        <p>¡Buen trabajo descubriendo su huella de carbono con nuestra Calculadora Lite! Para profundizar y obtener más información, consulte Calculadora avanzada.</p>
                                    </div>
                                </div>
                            </div>
                        </fieldset>



                    </form>
                </div>
            </div>
        </div>
    </div>

      <?php

   }

?>
