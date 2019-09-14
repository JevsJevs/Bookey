$(document).ready(function()
{
	$("#Cadastra").submit(function()
		{
			$.ajax( 
			{
				type:"POST",
				url:"http://143.106.241.1/cl17126/Bookey/untitled1/CadastroCli.php",
				username:"cl17126",
				password:"cl*13022002",
				data: {
					nome:"nome",
					email:"email",
					dnasc:"dnasc",
					nick:"nick",
					telefone:"cel",
					senha1:"senha1",
					senha2:"senha2"
				},
				dataType:'json',
				success: function(json) {$('resposta').html(json.status);},
				error: function(json) {$('resposta').html(json.status);}
			});
		});
});






	