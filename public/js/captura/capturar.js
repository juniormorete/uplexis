$(document).ready(() => {
    $('#frmCaptura').on('keyup keypress', function (e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });

    $('#btnCapturar').on('click', function () {
        let botao = this;

        if ($(botao).is('disabled'))
            return;

        // Desabilitando campo de busca
        $(botao).closest('.input-group').find('input, button').addClass('disabled').prop('readonly', true);

        let oDivResultado = $(botao).closest('.card').find('.card-body #divResultado');

        // Limpando o corpo do card
        $(oDivResultado).html($('<div>').addClass('col-auto').html('Carregando...'));

        $.ajax({
            url: $('#frmCaptura').attr("action") ?? window.location.href,
            type: "POST",
            async: true,
            data: $('#frmCaptura').serialize()
        })
            .done(function (response) {
                if (!response)
                    response = {};

                $(oDivResultado).html('');

                if ("OK" !== response?.sts) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response?.message ?? 'Houve uma falha na comunicação com o servidor',
                        confirmButtonColor: '#d33'
                    });
                    return;
                }

                $(oDivResultado)
                    .append($('<div>').addClass('col-12 text-center')
                        .append($('<h4>').html("Veículos carregados com palavra-chave \"" + response.palavraChave + "\""))
                    );

                if (!response?.estoque || (response?.estoque.length ?? 0) <= 0) {
                    $(oDivResultado).append($('<div>').addClass('col-12 text-center').html('Nenhum registro encontrado'));
                    return;
                }

                $.each(response.estoque, (k, veiculo) => {
                    let cardVeiculo = $('<div>').addClass('col-xl-6 col-lg-12')
                        .append($('<div>').addClass('card')
                            .append($('<div>').addClass('card-body')
                                .append($('<div>').addClass('row')
                                    .append($('<div>').addClass('col-4')
                                        .append($('<img>').addClass('rounded float-left').attr('src', veiculo.link_img))
                                    )
                                    .append($('<div>').addClass('col-8')
                                        .append($('<div>').addClass('row divDados')
                                            .append($('<div>').addClass('col')
                                                .append($('<h5>').addClass('text-truncate')
                                                    .append($('<a>').attr({ href: veiculo.link, target: '_blank' }).html(veiculo.nome_veiculo))
                                                )
                                            )
                                        )
                                    )
                                )
                            )
                        );

                    // Colunas de informações
                    $.each({
                        ano: 'Ano',
                        quilometragem: 'KM',
                        combustivel: 'Combustível',
                        cambio: 'Câmbio',
                        portas: 'Portas',
                        cor: 'Cor'
                    }, (campo, label) => {
                        $(cardVeiculo).find('.divDados').append($('<div>').addClass('col-6').html('<b>' + label + '</b>: ' + (veiculo[campo] ?? '(não informado)')))
                    });

                    $(oDivResultado).append(cardVeiculo);
                });
            })
            .fail(function (response) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Houve uma falha na comunicação com o servidor',
                    confirmButtonColor: '#d33'
                });
            }).always(function (response) {
                // Habilitando campo de busca
                $(botao).closest('.input-group').find('input, button').removeClass('disabled').prop('readonly', false);
            });
    });
});