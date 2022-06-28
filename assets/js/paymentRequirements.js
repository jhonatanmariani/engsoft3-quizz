function validateForm(step) {
    let errors = '';
    const formData = formDataToJson('msform');
    const dateMin = moment(new Date()).add(1, 'days');
    switch (step) {
        case 1:
            if (formData.origin.trim() == '') errors += '<b>Origem de despesa</b> é obrigatório<br>';
            if (formData.type.trim() == '') errors += '<b>Tipo de Despesa</b> é obrigatório<br>';
            if (formData.description.trim() == '') errors += '<b>Descrição da despesa</b> é obrigatório<br>';
            switch (parseInt(formData.type)) {
                case 1:
                    if (formData.travelOrigin.trim() == '') errors += '<b>Origem</b> é obrigatório<br>';
                    if (formData.travelDestiny.trim() == '') errors += '<b>Destino</b> é obrigatório<br>';
                    if (formData.travelCia.trim() == '') errors += '<b>Companhia</b> é obrigatório<br>';
                    if (formData.travelOrderNumber.trim() == '') errors += '<b>Localizador ou Número do Pedido</b> é obrigatório<br>';
                    if (formData.travelPassengerNumber.trim() == '') errors += '<b>Número do Passageiro</b> é obrigatório<br>';
                    if (formData.travelReason.trim() == '') errors += '<b>Motivo da Viagem</b> é obrigatório<br>';
                    if (formData.travelValue.trim() == '') errors += '<b>Valor da Viagem</b> é obrigatório<br>';
                    if (formData.travelBond.trim() == '') errors += '<b>Vínculo com o NOVO</b> é obrigatório<br>';
                    break;
                case 2:
                    if (formData.accommodationBeneficiary.trim() == '') errors += '<b>Beneficiário</b> é obrigatório<br>';
                    if (formData.accommodationHotel.trim() == '') errors += '<b>Hotel</b> é obrigatório<br>';
                    if (formData.accommodationStart.trim() == '') errors += '<b>Início da Hospedagem</b> é obrigatório<br>';
                    if (formData.accommodationEnd.trim() == '') errors += '<b>Fim da Hospedagem</b> é obrigatório<br>';
                    if (formData.accommodationReason.trim() == '') errors += '<b>Motivo da Hospedagem</b> é obrigatório<br>';
                    if (formData.accommodationBond.trim() == '') errors += '<b>Vínculo com o NOVO</b> é obrigatório<br>';
                    break;
                case 3:
                    if (formData.taxiBeneficiary.trim() == '') errors += '<b>Beneficiário</b> é obrigatório<br>';
                    if (!validateCpf(formData.taxiCpf)) errors += '<b>CPF</b> inválido<br>';
                    if (formData.taxiReason.trim() == '') errors += '<b>Motivo</b> é obrigatório<br>';
                    if (formData.taxiRoute.trim() == '') errors += '<b>Trajeto</b> é obrigatório<br>';
                    if (formData.taxiValue.trim() == '') errors += '<b>Valor</b> é obrigatório<br>';
                    break;
                case 4:
                    if ($('#campaignMaterial').val() == '') errors += '<b>Anexar imagem</b> é obrigatório<br>';
                    break;
                case 5:
                    if (formData.fuelPlate.trim() == '') errors += '<b>Placa</b> é obrigatório<br>';
                    if (formData.fuelName.trim() == '') errors += '<b>Nome do Condutor</b> é obrigatório<br>';
                    if (formData.fuelBond.trim() == '') errors += '<b>Vínculo com o NOVO</b> é obrigatório<br>';
                    if (formData.fuelValue.trim() == '') errors += '<b>Valor</b> é obrigatório<br>';
                    break;
                case 6:
                    if (formData.eventDate.trim() == '') errors += '<b>Data</b> é obrigatório<br>';
                    if (formData.eventName.trim() == '') errors += '<b>Nome do Evento</b> é obrigatório<br>';
                    break;
                case 7:
                    if (formData.buyAssets.trim() == '0') errors += '<b>Selecione um ativo</b><br>';
                    break;
                case 8:
                    if (formData.laborName.trim() == '') errors += '<b>Nome do Prestador</b> é obrigatório<br>';
                    if (formData.laborCPF.trim() == '') errors += '<b>CPF</b> é obrigatório<br>';
                    if (formData.laborOccupation.trim() == '') errors += '<b>Função do Prestador</b> é obrigatório<br>';
                    break;
                case 9:
                    //não foi feito nada aqui
                    break;
                case 10:
                    if (formData.accountConsumer.trim() == '0') errors += '<b>Selecione uma conta</b><br>';
                    break;
                case 11:
                    //não foi feito nada aqui
                    break;
            }
            break;
        case 2:
            if (formData.origin == 3) {
                if ($('#attachmentContract').val() == '') errors += '<b>Anexe um Contrato</b><br>';
                if ($('#attachmentNf').val() == '') errors += '<b>Anexe uma Nota Fiscal</b><br>';
            }
            if (formData.providerType.trim() == '') errors += '<b>Tipo de Fornecedor</b> é obrigatório<br>';
            if (formData.providerDoc.trim() == '') errors += '<b>CNPJ/CPF do Fornecedor</b> é obrigatório<br>';
            if (formData.providerName.trim() == '') errors += '<b>Razão Social/Nome do Fornecedor</b> é obrigatório<br>';
            if (formData.nfNumber.trim() == '') errors += '<b>Número da Nota/Recibo</b> é obrigatório<br>';
            if (formData.nfValue.trim() == '') errors += '<b>Valor da Nota Fiscal</b> é obrigatório<br>';
            if (formData.paymentMethod.trim() == '0') errors += '<b>Forma de Pagamento</b> é obrigatório<br>';
            if (formData.paymentMethod.trim() != '0') {
                switch (parseInt(formData.paymentMethod)) {
                    case 1:
                        if (!moment(formData.paymentSlipDueDate, 'DD/MM/YYYY', true).isValid()) errors += '<b>Vencimento</b> valor inválido<br>';
                        if (formData.billAmount.trim() == '') errors += '<b>Valor do Boleto</b> é obrigatório<br>';
                        if (moment(formData.paymentSlipDueDate, 'DD/MM/YYYY', true).isValid() &&
                            moment(formData.paymentSlipDueDate, 'DD/MM/YYYY').format('YYYY/MM/DD') < dateMin.format('YYYY/MM/DD')) {
                            errors += `<b>Vencimento</b> data minima ${dateMin.format('DD/MM/YYYY')} <br>`;
                        }
                        break;
                    case 2:
                        if (!moment(formData.depositMaturityDueDate, 'DD/MM/YYYY', true).isValid()) errors += '<b>Vencimento</b> valor inválido<br>';
                        if (moment(formData.depositMaturityDueDate, 'DD/MM/YYYY', true).isValid() &&
                            moment(formData.depositMaturityDueDate, 'DD/MM/YYYY').format('YYYY/MM/DD') < dateMin.format('YYYY/MM/DD')) {
                            errors += `<b>Vencimento</b> data minima ${dateMin.format('DD/MM/YYYY')} <br>`;
                        }
                        if (formData.depositAmount.trim() == '') errors += '<b>Valor do Depósito</b> é obrigatório<br>';
                        if (formData.paymentDoc.trim() == '') errors += '<b>CPF/CNPJ</b> é obrigatório<br>';
                        if (formData.paymentName.trim() == '') errors += '<b>Nome/Razão Social</b> é obrigatório<br>';
                        if (formData.paymentBank.trim() == '') errors += '<b>Banco</b> é obrigatório<br>';
                        if (formData.paymentBankAgency.trim() == '') errors += '<b>Agência</b> é obrigatório<br>';
                        if (formData.paymentBankAccount.trim() == '') errors += '<b>Conta Corrente</b> é obrigatório<br>';
                        break;
                }
            }
            break;
    }
    if (errors != '') {
        divMessageForm.innerHTML = errors;
        divMessageForm.classList.add("alert-danger");
        divMessageForm.classList.remove("alert-success");
        divMessageForm.classList.remove("d-none");
        return false;
    }
    return true;

}