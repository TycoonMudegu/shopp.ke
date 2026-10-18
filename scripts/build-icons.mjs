import { icons } from 'lucide';
import { writeFile } from 'node:fs/promises';

const names = ['ArrowUpRight', 'ArrowRight', 'ArrowDown', 'ArrowLeft', 'Plus', 'Minus', 'Menu', 'X', 'Check', 'CheckCheck', 'CircleCheck', 'ShoppingBag', 'Store', 'Smartphone', 'Truck', 'Package', 'MapPin', 'Mail', 'Phone', 'MoveUpRight', 'ShieldCheck', 'ChevronDown', 'ChevronRight', 'Search', 'Send', 'CreditCard', 'Copy', 'Clock', 'CircleHelp', 'ExternalLink', 'Heart', 'Leaf'];
const escape = value => String(value).replaceAll('&', '&amp;').replaceAll('"', '&quot;').replaceAll('<', '&lt;');
const symbols = names.map(name => {
  const id = name.replace(/([a-z0-9])([A-Z])/g, '$1-$2').toLowerCase();
  const nodes = icons[name];
  if (!nodes) throw new Error('Missing Lucide icon: ' + name);
  return '<symbol id="' + id + '" viewBox="0 0 24 24">' + nodes.map(([tag, attrs]) => '<' + tag + ' ' + Object.entries(attrs).map(([key, value]) => key + '="' + escape(value) + '"').join(' ') + '/>').join('') + '</symbol>';
});
await writeFile(new URL('../public/assets/icons.svg', import.meta.url), '<svg xmlns="http://www.w3.org/2000/svg">' + symbols.join('') + '</svg>');
console.log('Built ' + symbols.length + ' Lucide icons.');
