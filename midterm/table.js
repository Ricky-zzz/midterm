document.addEventListener('alpine:init', () => {
    Alpine.data('recordsTable', () => ({
        records: [],
        loading: true,
        error: '',

        async init() {
            await this.fetchRecords();
        },

        async fetchRecords() {
            try {
                this.loading = true;
                this.error = '';

                const response = await fetch('http://localhost:5000/api/index');

                if (!response.ok) {
                    throw new Error(`Failed to fetch records (Status: ${response.status})`);
                }

                const data = await response.json();
                this.records = data;

            } catch (err) {
                this.error = 'Cannot connect to API. Make sure Flask app is running on http://localhost:5000';
                console.error('Fetch error:', err);
            } finally {
                this.loading = false;
            }
        }
    }));
});
