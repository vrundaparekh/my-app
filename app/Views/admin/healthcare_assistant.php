<?= $this->extend('layouts/master') ?>

<?= $this->section('title') ?>AI Healthcare Assistant<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        
        <div class="alert alert-warning border-0 shadow-sm p-3 mb-4">
            <div class="d-flex align-items-start gap-2">
                <i class="fa-solid fa-triangle-exclamation text-warning fs-4 mt-1"></i>
                <div>
                    <h5 class="alert-heading fw-bold mb-1" style="font-size: 1rem;">Important Medical Disclaimer</h5>
                    <p class="mb-0 small text-dark opacity-85">
                        This interactive AI Assistant provides <strong>general educational information only</strong> regarding common symptoms, drugs, and wellness queries. It does not provide medical diagnoses, treatment options, or clinical prescriptions, and <strong>does not replace professional medical advice</strong>, diagnosis, or treatment from qualified healthcare practitioners.
                    </p>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm overflow-hidden text-center p-5 bg-white">
            <div class="mb-4">
                <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 rounded-circle mb-3" style="width: 80px; height: 80px;">
                    <i class="fa-solid fa-user-md text-success fs-1"></i>
                </div>
                <h3 class="fw-bold text-dark mb-2">Voice Assistant Companion</h3>
                <p class="text-muted small px-3">
                    Click the widget button below to initiate a real-time, bidirectional voice call regarding drugs, common symptoms, or generic medical information.
                </p>
            </div>

            <div class="d-flex justify-content-center py-3">
              
                <elevenlabs-convai agent-id="agent_2501kvd17s2ffaht8nkmvaqk4w4m"></elevenlabs-convai>
<script src="https://elevenlabs.io/convai-widget/index.js" async></script>
            </div>

            <div class="border-top pt-4 mt-4 text-start">
                <h6 class="small fw-bold text-secondary mb-2">Suggested things to ask:</h6>
                <ul class="text-muted small ps-3 mb-0">
                    <li>"What are the common side effects of Paracetamol?" </li>
                    <li>"What causes a mild tension headache?" </li>
                    <li>"How many hours of sleep does an adult need daily?" </li>
                </ul>
            </div>
        </div>

    </div>
</div>
<?= $this->endSection() ?>

