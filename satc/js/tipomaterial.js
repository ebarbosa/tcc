$(document).ready(function()
{
	var slt_tipo = $("select[name=slt_tipo]");
	var slt_material = $("select[name=slt_material]");
	var hdn_material = $("input[name=hdn_material]");

	if(slt_tipo.val() != 0)
	{
		$.post(
			"carregamaterialcadastro.php",
			{cod_mat: hdn_material.val()},
			function(valor){slt_material.html(valor);}
		);

		slt_material.attr('disabled', false);
	}
	slt_tipo.change(function()
	{
		slt_material.html('<option value="0">Carregando...</option>');

		$.post(
			"carregamateriais.php",
			{cod_tip: slt_tipo.val()},
			function(valor){slt_material.html(valor);}
		);

		if(slt_tipo.val() != 0)
			slt_material.attr('disabled', false);
		else
			slt_material.attr('disabled', true);
	});
});