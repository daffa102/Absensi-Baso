// Auto-Save Mixin untuk semua form
// Copy script ini ke setiap form create/edit

function formAutoSave(formName, fields) {
    return {
        uploading: false,

        // Persist form data to localStorage
        formData: Alpine.$persist(
            fields.reduce((acc, field) => {
                acc[field] = '';
                return acc;
            }, {})
        ).as(formName),

        init() {
            // Sync persisted data with Livewire on mount
            Object.keys(this.formData).forEach(field => {
                if (this.formData[field] !== '' && this.formData[field] !== null && this.formData[field] !== undefined) {
                    if (this.$wire) {
                        this.$wire.set(field, this.formData[field]);
                    }
                }
            });

            // Watch for changes and save to localStorage
            this.$watch('formData', value => {
                // console.log(`[${formName}] Form data auto-saved`);
            });

            // Clear localStorage on successful save
            Livewire.on('form-saved', () => {
                this.clearFormData();
            });
        },

        clearFormData() {
            this.formData = fields.reduce((acc, field) => {
                acc[field] = '';
                return acc;
            }, {});
            localStorage.removeItem(formName);
        },

        hasData() {
            return Object.values(this.formData).some(val => val !== '');
        }
    }
}

// USAGE EXAMPLES:

// 1. Data Siswa Create
// x-data="formAutoSave('siswa_create_form', ['nis', 'nama', 'kelas_id', 'tahun_ajar_id'])"

// 2. Data Kelas Create
// x-data="formAutoSave('kelas_create_form', ['nama_kelas'])"

// 3. Tahun Ajar Create
// x-data="formAutoSave('tahun_ajar_create_form', ['nama', 'tanggal_mulai', 'tanggal_selesai'])"

// 4. Signature Create (already done)
// x-data="formAutoSave('signature_create_form', ['role', 'name', 'nip'])"
