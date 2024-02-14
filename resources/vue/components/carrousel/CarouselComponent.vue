<template>
    <div class="card glass">
        <div class="mt-4 mb-4">
            <div id="mfp-carousel" class="carousel slide">
                <div class="carousel-inner">
                    <slot/>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#mfp-carousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#mfp-carousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "MfpCarousel"
}
</script>