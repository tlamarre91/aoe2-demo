<template>
    <div class="editable-list">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="table-key">
                  {{ key }}
                </div>
                <!-- TODO -->
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('EditableList mounted.');
        },
        yeeted() {
            console.log("yeeted");
        }
    }
</script>

