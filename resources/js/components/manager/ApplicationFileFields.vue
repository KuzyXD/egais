<template>
    <div class="flex flex-col gap-2">
        <file-input v-for="[key, value] of Object.entries(urFiles)" :key="key" :ref="key" :en_title="key" :title="value"
                    @fileChange="(incomingValue)=> this.files[key]=incomingValue"></file-input>
    </div>
</template>

<script>
import fileInput from "./TemplatesForm/FileInput";
import {ApplicationFiles} from "./ApplicationFiles";

export default {
    components: {fileInput},
    data() {
        return {
            files: {},
            urFiles: ApplicationFiles
        }
    },
    methods: {
        clearData() {
            for (const key of Object.keys(this.urFiles)) {
                this.$refs[key][0].clearValue();
            }

        }
    },
    watch: {
        files: {
            handler(newValue, oldValue) {
                this.$emit('filesInput', this.files);
            },
            deep: true
        }
    },
}
</script>

<style scoped>

</style>
