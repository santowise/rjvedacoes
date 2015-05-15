

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->
        
        
        <!-- Mostra URL do site em todas as página para uso em javascript -->
        <input type="hidden" id="host_url" value="<?php echo HOST_URL ?>" />


        <!-- jQuery 2.0.2 -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="<?php echo HOST_URL ?>/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- InputMask -->
        <script src="<?php echo HOST_URL ?>/js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
        <script src="<?php echo HOST_URL ?>/js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
        <script src="<?php echo HOST_URL ?>/js/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
        <!-- date-range-picker -->
        <script src="<?php echo HOST_URL ?>/js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <!-- bootstrap color picker -->
        <script src="<?php echo HOST_URL ?>/js/plugins/colorpicker/bootstrap-colorpicker.min.js" type="text/javascript"></script>
        <!-- bootstrap time picker -->
        <script src="<?php echo HOST_URL ?>/js/plugins/timepicker/bootstrap-timepicker.min.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        <script src="<?php echo HOST_URL ?>/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="<?php echo HOST_URL ?>/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="<?php echo HOST_URL ?>/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
        
        <script src="<?php echo HOST_URL ?>/js/plugins/jquery-validate/jquery.validate.js" type="text/javascript"></script>
        <!-- Máscara de Moeda -->
        <script src="<?php echo HOST_URL ?>/js/plugins/jquery-maskmoney/money_mask.js" type="text/javascript"></script>
        <!-- Input File -->
        <script src="<?php echo HOST_URL ?>/js/plugins/bootstrap-filestyle/bootstrap-filestyle.min.js" type="text/javascript"></script>
		<!-- LightBox -->
		<script src="<?php echo HOST_URL ?>/js/plugins/ekko-lightbox/ekko-lightbox.js"></script>
        <!-- DatePicker -->
		<script src="<?php echo HOST_URL ?>/js/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
        <!-- Colorbox -->
        <script src="<?php echo HOST_URL ?>/js/plugins/colorbox/jquery.colorbox-min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo HOST_URL ?>/js/AdminLTE/app.js" type="text/javascript"></script>

        <!-- Page script -->
        <script type="text/javascript">
			
			$(document).ready(function()
			{    
				//Inicializa ColorBox
				$(".cb_frame").colorbox({width:"90%", height:"95%", iframe:true});
				
				
				// delegate calls to data-toggle="lightbox"
				$(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
					event.preventDefault();
					return $(this).ekkoLightbox({
						onShown: function() {
							if (window.console) {
								return console.log('Checking our the events huh?');
							}
						}
					});
				});	
				
				
				//jQuery Validate
				$("form").validate({					
   					ignore: ":hidden:not(textarea)"
				});
				
				
                //bootstrap WYSIHTML5 - text editor
                $(".wysihtml5").wysihtml5();
				
				
				//Ativa as máscaras
				mascaras();
				
				
				//Ativa o Filestyle
				inputFile();
			});
			
			
			//Filestyle
			function inputFile()
			{				
				$(":file").filestyle();
			}
			
			
			//Máscaras
			function mascaras()
			{
                //Máscara para CNPJ
                $(".mascara_cnpj").inputmask("99.999.999/9999-99",{ clearIncomplete: true });
                //Máscara para CPF
                $(".mascara_cpf").inputmask("999.999.999-99",{ clearIncomplete: true });
                //Máscara para CEP
                $(".mascara_cep").inputmask("99999-999",{ clearIncomplete: true });
                //Máscara para Data
                $(".mascara_hora").inputmask("99:99",{ clearIncomplete: true });
                //Máscara para Telefone
   				$(".mascara_telefone").inputmask("(99) 9999-9999[9]",{clearMaskOnLostFocus: true, clearIncomplete: true});
				//Máscara para Moeda
				$(".mascara_moeda").maskMoney({showSymbol:false, symbol:"R$", decimal:".", thousands:""});
                //Máscara para campo numérico
                $(".mascara_numero").inputmask("9[9][9][9][9][9][9][9][9]",{ clearIncomplete: true });
			}
			
			
			
			//Funcao para mostrar imagem do evento depois de cropada
			function mostrar_imagem_cortada(nome_imagem,pasta)
			{
				//Limpa div que mostra imagem cropada
				$("#imagem_crop").empty();
				
				
				//Pega URL do site
				var host_url = $("#host_url").val();
				
				
				//Adiciona imagem na div
				$("#imagem_crop").append('<img src="'+host_url+'/sistema/'+pasta+'/imgs_crop_temporarias/'+nome_imagem+'" width="160" />');
				
				
				//Oculta Div para fazer efeito fadeIn
				/*$("#imagem_crop").hide();
				$("#imagem_crop").fadeIn('slow');*/
			
			
				//Preencho campo oculto do formulário que armazenara nome da imagem cropada
				$("#imagem_cropada").val(nome_imagem);
			}

			
			
			
			$(function()
			{
				//DatePicker
				$(".datepicker").datepicker({ format: 'dd/mm/yyyy' });				
				$('.datepicker').on('changeDate', function(ev){
					$(this).datepicker('hide');
				});
				
                //Date range picker
                $('#daterangepicker').daterangepicker({format: 'DD/MM/YYYY'});
                //Date range picker with time picker
                /*$('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
                //Date range as a button
                $('#daterange-btn').daterangepicker(
                        {
                            ranges: {
                                'Today': [moment(), moment()],
                                'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                                'Last 7 Days': [moment().subtract('days', 6), moment()],
                                'Last 30 Days': [moment().subtract('days', 29), moment()],
                                'This Month': [moment().startOf('month'), moment().endOf('month')],
                                'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                            },
                            startDate: moment().subtract('days', 29),
                            endDate: moment()
                        },
                function(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                }
                );*/

                //iCheck for checkbox and radio inputs
                $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                    checkboxClass: 'icheckbox_minimal',
                    radioClass: 'iradio_minimal'
                });
				//Red color scheme for iCheck
                $('input[type="checkbox"].minimal-blue, input[type="radio"].minimal-blue').iCheck({
                    checkboxClass: 'icheckbox_minimal-blue',
                    radioClass: 'iradio_minimal-blue'
                });
				//red color scheme for iCheck
                $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
                    checkboxClass: 'icheckbox_minimal-red',
                    radioClass: 'iradio_minimal-red'
                });
				//green color scheme for iCheck
                $('input[type="checkbox"].minimal-green, input[type="radio"].minimal-green').iCheck({
                    checkboxClass: 'icheckbox_minimal-green',
                    radioClass: 'iradio_minimal-green'
                });
				//purple color scheme for iCheck
                $('input[type="checkbox"].minimal-purple, input[type="radio"].minimal-purple').iCheck({
                    checkboxClass: 'icheckbox_minimal-purple',
                    radioClass: 'iradio_minimal-purple'
                });
				//orange color scheme for iCheck
                $('input[type="checkbox"].minimal-orange, input[type="radio"].minimal-orange').iCheck({
                    checkboxClass: 'icheckbox_minimal-orange',
                    radioClass: 'iradio_minimal-orange'
                });
				//yellow color scheme for iCheck
                $('input[type="checkbox"].minimal-yellow, input[type="radio"].minimal-yellow').iCheck({
                    checkboxClass: 'icheckbox_minimal-yellow',
                    radioClass: 'iradio_minimal-yellow'
                });

                //Colorpicker
                $(".my-colorpicker1").colorpicker();
                //color picker with addon
                $(".my-colorpicker2").colorpicker();

                //Timepicker
                $(".timepicker").timepicker({
                    showInputs: false
                });
            });
        </script>       

    </body>
</html>