<template>
	<v-container fluid class="pa-1">
		<v-carousel
			rounded="xl"
			hide-delimiter-background
			:height="heightCarousel"
			show-arrows="hover"
			cycle
			style="border-radius: 20px"
		>
			<a
				v-for="(images, index) in carousel"
				:key="index"
				:href="images.link"
				target="_blank"
			>
				<v-carousel-item
					:src="images.src"
					cover
					draggable
					:height="heightCarousel"
					position="center center"
					class="cursor-pointer"
				/>
			</a>
		</v-carousel>
	</v-container>
</template>

<script setup>
// Exemplos de lista para imagens e links
// Todas as imagens são da Unsplash
const heightCarousel = 250
const carousel = [
	{
		src: "https://images.unsplash.com/photo-1461749280684-dccba630e2f6?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
		link: "/",
	},
	{
		src: "https://images.unsplash.com/photo-1554080353-a576cf803bda?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
		link: "/",
	},
	{
		src: "https://images.unsplash.com/photo-1482164565953-04b62dcac1cd?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
		link: "/",
	},
]
</script>
