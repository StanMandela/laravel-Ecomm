const state= {
     user : {
            token:sessionStorage.getItem('TOKEN'),
            data:{}
        },
    products:{
        loading:false,
        data:[],
        links:[],
        to:null,
        from:null,
        page:1,
        limit:null,
        total:null
    }
  
};

export default state;