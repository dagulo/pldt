var client = null;
var index  = null;

var searchVue = new Vue({
    el:'#searchDiv',
    data:{
        results:[]
    },
    methods:{
        ask:function()
        {
            q = $('#question').val();

            client = $.algolia.Client('Y6CWHYKYU9', '9d13cfb8af22a64cdbd8f701787cb544');
            index = client.initIndex( 'faq');
            index.search( q , function searchDone(err, content) {
                console.log(err, content);
                    searchVue.$data.results = [];
                    for( i=0; i < content.hits.length; i++ ){
                        d = content.hits[i];
                        searchVue.$data.results.push( d )
                    }
            });
        }


    },
    ready:function(){
    
    }
});