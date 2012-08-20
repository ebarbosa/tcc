$(document).ready(function()
{
	var slt_estado = $("select[name=slt_estado]");
	var slt_cidade = $("select[name=slt_cidade]");
	var hdn_cidade = $("input[name=hdn_cidade]");

	if(slt_estado.val() != 0)
	{
		$.post(
			"carregacidadecadastro.php",
			{cod_cid: hdn_cidade.val()},
			function(valor){slt_cidade.html(valor);}
		);

		slt_cidade.attr('disabled', false);
	}
	slt_estado.change(function()
	{
		slt_cidade.html('<option value="0">Carregando...</option>');

		$.post(
			"carregacidades.php",
			{cod_est: slt_estado.val()},
			function(valor){slt_cidade.html(valor);}
		);

		if(slt_estado.val() != 0)
			slt_cidade.attr('disabled', false);
		else
			slt_cidade.attr('disabled', true);
	});
});