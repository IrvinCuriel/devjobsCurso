<template>
  <div>
      <ul class="flex flex-wrap justify-center">
        <li
            class="border border-gray-500 px-10 py-3 mb-3 rounded mr-4"
            :class="verificarClaseActiva(skill) "
            v-for="( skill, i ) in this.skills"
            v-bind:key="i"
            v-on:click="activar"
        >{{skill}}</li>
      </ul>
      <input type="hidden" name="skills" id="skills">
  </div>
</template>

<script>
export default {
  props: ['skills', 'oldskills'],
  /*
  mounted() {
    console.log(this.skills);
  },
  */
  data: function() {
    return {
        habilidades: new Set()
    }
  },
  created: function() {
    //console.log(1);
    if(this.oldskills) {
      const skillsArray = this.oldskills.split(',');
      //console.log(skillsArray);
      skillsArray.forEach( skill => this.habilidades.add(skill) );
    }
  },
  mounted: function() {
    //console.log(this.oldskills);
    //console.log(2);
    document.querySelector('#skills').value = this.oldskills;
  },
  methods: {
    activar(e) {
      //console.log('diste clicks');
      //console.log('diste clicks', e.target.textContent);
      if( e.target.classList.contains('bg-teal-400') ) {
        // el skill esta activo
        e.target.classList.remove('bg-teal-400');
        // Eliminar del set de Habilidades
        this.habilidades.delete(e.target.textContent);
      } else {
        // No esta activo, añadirlo
        e.target.classList.add('bg-teal-400');
        // Agregar al set de habilidades
        this.habilidades.add(e.target.textContent);
      }

      // agregar las habilidades al input hidden
      const stringHabilidades = [...this.habilidades];
      document.querySelector('#skills').value = stringHabilidades;

    },
    verificarClaseActiva(skill) {
        //console.log('skill');
        return this.habilidades.has(skill) ? 'bg-teal-400' : '';
    }

  }
}
</script>
