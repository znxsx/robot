;
(function ()
{
    'use strict';
    angular.module('base_app.service')
        .service('SAgency',
        [
            'H',
            'h',
            'ngDialog',
            function (H,
                      h,
                      ngDialog)
            {
                var me = this;
                me.init = init;
                me.status_type = h.agency_status;
                me.refresh = refresh;
                me.change_page = change_page;
                me.popup_edit = popup_edit;
                me.h = h.ins_helper;
                me.cu = cu;
                me.d = d;
                me.current_page_data = null;
                //me.current_page = 1;
                me.total_items = null;
                me.items_per_page = 50;
                me.ins_name = 'agency';
                me.cond = {
                    relation: [],
                    where: {},
                    where_has: {},
                };

                me.status = get_status;

                me.get_all_rec = function()
                {
                    H.p(cook('agency/r'), {'limit' : 0})
                        .then(function(r)
                        {
                            me.all_rec = r.data.d.main;
                        })
                }

                function get_status(row)
                {
                    if (row.status == 0)
                        return '已冻结';
                    if (moment().isBetween(row.started_at, row.ended_at))
                        return 'OK';
                    return '已过期';
                }

                function cu(d)
                {
                    h.cu.apply(me, arguments);
                }

                function d(id)
                {
                    return H.p(cook(me.ins_name + '/d'), {id: id})
                        .then(function (r)
                        {
                            if (r.data.d)
                            {
                                me.refresh();
                            }
                        }, function ()
                        {
                        })
                }

                function popup_edit(row)
                {
                    console.log('row: ', row);

                    h.popup_form.call(me, row)
                }

                function refresh()
                {
                    h.prepare_cond.call(me);
                    return H.p(cook(me.ins_name + '/r'),
                        me.cond)
                        .then(function (r)
                        {
                            if (!me.total_items)
                                me.total_items = r.data.d.count;
                            me.current_page_data = r.data.d.main;
                            console.log('me.current_page_data: ', me.current_page_data);

                            return r;
                        })
                }

                function change_page(pagination)
                {
                    me.cond.pagination = pagination;
                    me.refresh();
                }

                function init()
                {
                    //h.get_all_hospital()
                    //    .then(function(r)
                    //    {
                    //        me.all_hospital = r.data.d.main;
                    //    })
                    //me.refresh()
                }
            }
        ])
})();