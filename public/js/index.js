window.onload = () => {
    const app = Vue.createApp({
        data() {
            return {
              endpoints:[],
              BASE_URL: "http://localhost/apiRedSocial",
              id:"",
              archivo: "",
              contenido: "",
              fecha: "",
              id_usuario: "",
              respuestaGET: "",
            }
          },
        methods: {
            realizarPeticion() {
                fetch("./json/endpoints.json")
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error en la petición AJAX');
                        }
                        return response.json();
                    })
                    .then(data => {
                        this.endpoints = data;
                    })
                    .catch(error => {
                        console.error('Error al hacer la petición AJAX:', error);
                    });
            },
            click(id){
                change = this.endpoints.filter(data => data.id == id);
                change[0].show==false?change[0].show=true:change[0].show=false;
                this.endpoints = this.endpoints.map(data => {
                    if (data.id === id) {
                      return change[0];
                    } else {
                      return data;
                    }
                  });
                this.respuestaGET="";
            },
            peticionGET(string, token){
                if(string.includes(":id")){
                    string = string.replace(':id',this.id);
                }
                fetch(this.BASE_URL+string, {
                    method: 'GET',
                    headers:{
                        'Authorization': `Bearer ${token}`,
                    }
                })
                    .then(response => {
                        return response.json();
                    })
                    .then(data => {
                        this.respuestaGET = data;
                        this.id= "";
                    })
            },
            handleFileChange(event) {
                this.archivo = event.target.files[0];
            },
            peticionPOST(string,token){
                const jsonData = {
                    "id_usuario": parseInt(this.id_usuario),
                    "contenido": this.contenido,
                    "imagen": this.archivo.name,
                    "fecha_publicacion": this.fecha
                  };
                fetch(this.BASE_URL+string, {
                    method: 'POST',
                    headers:{
                        'Authorization': `Bearer ${token}`,
                    },
                    body:JSON.stringify(jsonData),
                })
                    .then(response => {
                        return response.json();
                    })
                    .then(data => {
                        this.respuestaGET = data;
                        this.id_usuario = "";
                        this.contenido = "";
                        this.archivo = "";
                        this.fecha = "";
                    })
            },
            peticionDelete(string, token){
                if(string.includes(":id")){
                    string = string.replace(':id',this.id);
                }
                fetch(this.BASE_URL+string, {
                    method: 'DELETE',
                    headers:{
                        'Authorization': `Bearer ${token}`,
                    }
                })
                    .then(response => {
                        return response.json();
                    })
                    .then(data => {
                        this.respuestaGET = data;
                        this.id= "";
                        this.id_usuario = "";
                        this.contenido = "";
                        this.archivo = "";
                        this.fecha = "";
                    })
            },
            peticionPut(string, token){
                const jsonData = {
                    "id_usuario": parseInt(this.id_usuario),
                    "contenido": this.contenido,
                    "imagen": this.archivo.name,
                    "fecha_publicacion": this.fecha
                  };
                if(string.includes(":id")){
                    string = string.replace(':id',this.id);
                }
                fetch(this.BASE_URL+string, {
                    method: 'PUT',
                    headers:{
                        'Authorization': `Bearer ${token}`,
                    },
                    body:JSON.stringify(jsonData),
                })
                    .then(response => {
                        return response.json();
                    })
                    .then(data => {
                        this.respuestaGET = data;
                        this.id= "";
                    })
            },
            peticionToken(string,method){
                fetch(this.BASE_URL+"/needToken", {
                    method: 'GET',
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la petición AJAX');
                    }
                    return response.json();
                })
                .then(data => {
                    switch (method){
                        case 'GET': 
                            this.peticionGET(string,data.token)
                            break;
                        case 'PUT':
                            this.peticionPut(string,data.token);
                            break;
                        case 'DELETE':
                            this.peticionDelete(string,data.token);
                            break;
                        case 'POST':
                            this.peticionPOST(string,data.token);
                            break;
                        default:;
                    }
                })
                .catch(error => {
                    console.error('Error al hacer la petición AJAX:', error);
                });
            }
        },
        mounted() {
            this.realizarPeticion();
        }
    });
    app.mount('#body');
}