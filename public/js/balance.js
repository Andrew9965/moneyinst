var initBalance = function(id, from){
    var form        = $('[data-api-form]'),
        obj_from    = form.find(".date_from"),
        obj_to      = form.find(".date_to"),
        obj_amount  = form.find(".amount"),
        obj_submit  = form.find('[type="submit"]'),
        date_from = '',
        date_to = '',
        amount = '',
        statistic = false,
        request = false;

    var getStatistic = function(){
        if(request) {
            request = false;
            var from = date_from.split('-');
            var to = date_to.split('-');
            $.get('/admin/auth/users_balance_get_statistic/'+id, {date_from: from[2]+'.'+from[1]+'.'+from[0], date_to: to[2]+'.'+to[1]+'.'+to[0]}, function(result){
                if(result.error!=undefined && result.error){
                    toastr.error(result.result, 'API Error');
                    obj_amount.val('');
                    statistic = false;
                }else{
                    obj_amount.val(result.result);
                    if(result.result=='0')
                        statistic = false;
                    else
                        statistic = true;
                }
            });
        }
        request = false;
    };

    obj_from.on("dp.change", function (e) {
        request = true;
    });
    obj_to.on("dp.change", function (e) {
        request = true;
    });

    var timer = setInterval(function(){
        if(from!='') obj_from.val(from);
        date_from = obj_from.val(); date_to = obj_to.val(); amount = obj_amount.val();
        if(date_from=='' || date_to=='' || !statistic){
            obj_submit.attr('disabled', 'true');
        }else{
            obj_submit.removeAttr('disabled');
        }
        if(date_from!='' && date_to!='') getStatistic();
    });
};
