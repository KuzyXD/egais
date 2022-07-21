import { reactive } from 'vue';

export const cadesplugin_initialization = reactive({
  state: 'loading',
  loadCadesPlugin() {
    let scriptElement = document.createElement('script');
    scriptElement.setAttribute('src', '/js/cadesplugin_api.js');
    scriptElement.setAttribute('language', 'javascript');
    document.body.appendChild(scriptElement);

    scriptElement.addEventListener('load', () => {
      this.enableCadesPlugin();
    });
  },
  enableCadesPlugin() {
    const vue = this;

    cadesplugin.then(
      function () {
        vue.state = 'loaded';
      },
      function (error) {
        vue.state = 'error';
        console.error(error);
      }
    );
  }
});
