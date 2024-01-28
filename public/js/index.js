window.onload = () => {
    const app = Vue.createApp({
        data() {
            return {
              endpoints:[],
              BASE_URL: "http://localhost/apiRedSocial",
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
            },
            peticion(string){
                // token = this.peticionToken();
                fetch(this.BASE_URL+string, {
                    method: 'GET',
                    headers:{
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                    }
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error en la petición AJAX');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log(data);
                    })
                    .catch(error => {
                        console.error('Error al hacer la petición AJAX:', error);
                    });
            },
            peticionToken(){
                fetch(this.BASE_URL+"/needToken", {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la petición AJAX');
                    }
                    return response.json();
                })
                .then(data => {
                    return data.token;
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