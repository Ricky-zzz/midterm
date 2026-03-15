document.addEventListener('alpine:init', () => {
    Alpine.data('insuranceForm', () => ({
        form: {
            age: '',
            sex: '',
            bmi: '',
            children: '',
            smoker: '',
            region: ''
        },
        loading: false,
        prediction: null,
        error: '',

        async submitForm() {
            try {
                this.error = '';
                this.prediction = null;
                
                if (!this.form.age || !this.form.sex || !this.form.bmi || 
                    this.form.children === '' || !this.form.smoker || !this.form.region) {
                    this.error = 'Please fill in all fields';
                    return;
                }

                this.loading = true;

                const response = await fetch('http://localhost:5000/api/predict', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(this.form)
                });

                if (!response.ok) {
                    throw new Error('Failed to get prediction');
                }

                const data = await response.json();
                this.prediction = data.prediction;

            } catch (err) {
                this.error = err.message || 'An error occurred. Please try again.';
                console.error(err);
            } finally {
                this.loading = false;
            }
        }
    }));
});