import { mkdir, writeFile } from 'node:fs/promises';

const assets = {
  'images/boutique.jpg': 'https://images.pexels.com/photos/8386665/pexels-photo-8386665.jpeg?auto=compress&cs=tinysrgb&w=2200&q=85',
  'images/seller-studio.jpg': 'https://images.pexels.com/photos/7857559/pexels-photo-7857559.jpeg?auto=compress&cs=tinysrgb&w=2000&q=85',
  'images/packing.jpg': 'https://images.pexels.com/photos/7857532/pexels-photo-7857532.jpeg?auto=compress&cs=tinysrgb&w=1400&q=85',
  'images/beauty.jpg': 'https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?auto=format&fit=crop&w=1000&q=85',
  'images/groceries.jpg': 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=1000&q=85',
  'images/electronics.jpg': 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=1000&q=85',
  'fonts/manrope.woff2': 'https://cdn.jsdelivr.net/fontsource/fonts/manrope:vf@latest/latin-wght-normal.woff2',
  'fonts/instrument-serif-italic.woff2': 'https://cdn.jsdelivr.net/fontsource/fonts/instrument-serif@latest/latin-400-italic.woff2',
};

for (const [path, url] of Object.entries(assets)) {
  const destination = new URL(`../public/assets/${path}`, import.meta.url);
  await mkdir(new URL('.', destination), { recursive: true });
  const response = await fetch(url);
  if (!response.ok) throw new Error(`${path}: HTTP ${response.status}`);
  await writeFile(destination, Buffer.from(await response.arrayBuffer()));
  console.log(`Downloaded ${path}`);
}
