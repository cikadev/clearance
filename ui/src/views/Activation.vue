<template>
    <div>
        <b-container>
            <b-form>
                <b-form-group
                    label="Toga Size"
                >
                    <b-select v-model="toga_size">
                        <b-select-option>Select</b-select-option>
                        <b-select-option value="xs">XS</b-select-option>
                        <b-select-option value="s">S</b-select-option>
                        <b-select-option value="m">M</b-select-option>
                        <b-select-option value="l">L</b-select-option>
                        <b-select-option value="xl">XL</b-select-option>
                        <b-select-option value="xxl">XXL</b-select-option>
                    </b-select>
                </b-form-group>
                <b-form-group
                    label="Card ID"
                >
                    <b-form-input placeholder="Tap the student card" v-model="card_id" />
                </b-form-group>
            </b-form>
        </b-container>
    </div>
</template>

<script>
export default {
    data() {
        return {
            card_id: "",
            toga_size: "",
        };
    }
}
</script>
