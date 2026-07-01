/* ============================================
   Carpe Diem — Lista de fotógrafos
   Futuramente substituída por chamada à API:
   GET /api/fotografos → retorna este mesmo formato
   ============================================ */

const CAMINHO_ASSETS = window.location.pathname.includes('/views/') ? 'assets/' : 'views/assets/';

const fotografos = [
  {
    id: 'lavinia-coimbra',
    nome: 'Lavínia Coimbra',
    cidade: 'Curitiba',
    estado: 'PR',
    especialidade: 'Casamentos',
    tags: ['Casamentos', 'Noivado', 'Pré-wedding'],
    avaliacao: 4.9,
    totalAvaliacoes: 32,
    experiencia: '6 anos de experiência',
    descricao: 'Fotógrafa especializada em casamentos com olhar autoral e clima leve. Atendo casais que valorizam leveza, espontaneidade e memórias bem cuidadas.',
    descricaoCompleta: 'Há 6 anos fotografo casamentos em Curitiba e região. Acredito que cada detalhe conta uma história — do nervosismo antes da cerimônia à última dança da noite. Meu estilo busca luz natural, cores quentes e momentos espontâneos que resistem ao tempo.',
    fotoCapa: `${CAMINHO_ASSETS}_common/images/galleries/lavinia/3ddd909fa028615e716b3f2570f3aa21.jpg`,
    fotoAvatar: `${CAMINHO_ASSETS}_common/images/profiles/lavinia.jpg`,
    galeria: [
      `${CAMINHO_ASSETS}_common/images/galleries/lavinia/0719b3b024eeffa1826a6920120608a7.jpg`,
      `${CAMINHO_ASSETS}_common/images/galleries/lavinia/3ddd909fa028615e716b3f2570f3aa21.jpg`,
      `${CAMINHO_ASSETS}_common/images/galleries/lavinia/7334db2701bf3f5121c2b2bab069c946.jpg`,
      `${CAMINHO_ASSETS}_common/images/galleries/lavinia/80c0e18152b33ad5cb7641651eb1738f.jpg`,
      `${CAMINHO_ASSETS}_common/images/galleries/lavinia/b11b1ddc2aa64f4f7bd1dff3899fa954.jpg`,
      `${CAMINHO_ASSETS}_common/images/galleries/lavinia/cc4197fe6c196220cd1a87041c8b6396.jpg`
    ]
  },
  {
    id: 'alicy-mailaender',
    nome: 'Alicy Mailaender',
    cidade: 'Florianópolis',
    estado: 'SC',
    especialidade: 'Ensaios',
    tags: ['Ensaios', 'Retrato', 'Street'],
    avaliacao: 4.8,
    totalAvaliacoes: 21,
    experiencia: '4 anos de experiência',
    descricao: 'Ensaios externos com luz natural. Foco em retratos sensíveis e composições minimalistas.',
    descricaoCompleta: 'Trabalho com fotografia de rua e ensaios em Florianópolis. Meu olhar é influenciado pelo cinema, com atenção especial à luz disponível e à expressão humana. Cada sessão é uma conversa visual.',
    fotoCapa: `${CAMINHO_ASSETS}_common/images/galleries/alicy/40814c55b11fefd66f7a3ea08348c5f5.jpg`,
    fotoAvatar: `${CAMINHO_ASSETS}_common/images/profiles/alicy.jpg`,
    galeria: [
      `${CAMINHO_ASSETS}_common/images/galleries/alicy/2834e9bea8d43bbf2850294f063b1363.jpg`,
      `${CAMINHO_ASSETS}_common/images/galleries/alicy/40814c55b11fefd66f7a3ea08348c5f5.jpg`,
      `${CAMINHO_ASSETS}_common/images/galleries/alicy/83e5475398106e46f50218cc353f757a.jpg`,
      `${CAMINHO_ASSETS}_common/images/galleries/alicy/95f2157d3509ddc2b5ddee057b0dc21e.jpg`,
      `${CAMINHO_ASSETS}_common/images/galleries/alicy/b1bc64149cfc2ba1765fef4b93b96b60.jpg`,
      `${CAMINHO_ASSETS}_common/images/galleries/alicy/f62ec35596f2fa21f1a681212fa0d99d.jpg`
    ]
  },
  {
    id: 'Ana-lia-vergamini',
    nome: 'Ana lia Vergamini',
    cidade: 'Porto Alegre',
    estado: 'RS',
    especialidade: 'Eventos',
    tags: ['Eventos', 'Corporativo', 'Festas'],
    avaliacao: 5.0,
    totalAvaliacoes: 47,
    experiencia: '9 anos de experiência',
    descricao: 'Cobertura de eventos corporativos e festas. Entrega ágil com edição cinematográfica.',
    descricaoCompleta: 'Especialista em cobertura de eventos em Porto Alegre há 9 anos. Atendo empresas e particulares com agilidade na entrega e uma edição com identidade própria — cores ricas, contraste equilibrado e narrativa visual clara.',
    fotoCapa: `${CAMINHO_ASSETS}_common/images/galleries/ana li/28ec45f0ec448e6eaf6d59b8c4998880.jpg`,
    fotoAvatar: `${CAMINHO_ASSETS}_common/images/profiles/ana.jpg`,
    galeria: [
      `${CAMINHO_ASSETS}_common/images/galleries/ana li/27d08709b658029d14bd22568ca0cc0a.jpg`,
      `${CAMINHO_ASSETS}_common/images/galleries/ana li/28ec45f0ec448e6eaf6d59b8c4998880.jpg`,
      `${CAMINHO_ASSETS}_common/images/galleries/ana li/76b0330cf59be1f53986a6b6a9576b8d.jpg`,
      `${CAMINHO_ASSETS}_common/images/galleries/ana li/861d71150c217cd227969a00f0b6418a.jpg`,
      `${CAMINHO_ASSETS}_common/images/galleries/ana li/a71e9ca8334de7b9e2040abf173dc8a1.jpg`,
      `${CAMINHO_ASSETS}_common/images/galleries/ana li/bc316af1dfdbbd566f3ec6f96972b740.jpg`
    ]
  },
  {
    id: 'lucas-ferraz',
    nome: 'Lucas Ferraz',
    cidade: 'Joinville',
    estado: 'SC',
    especialidade: 'Família',
    tags: ['Família', 'Gestante', 'Newborn'],
    avaliacao: 4.7,
    totalAvaliacoes: 18,
    experiencia: '5 anos de experiência',
    descricao: 'Ensaios de família e gestante. Cliques afetuosos que contam histórias reais.',
    descricaoCompleta: 'Acredito que fotografia de família é sobre presença — estar ali quando o amor aparece de forma espontânea. Atendo em Joinville e região com sessões externas e de estúdio, incluindo newborn e gestante.',
    fotoCapa: `${CAMINHO_ASSETS}_common/images/galleries/lucas/68156a8bc973df145c1d3c5c6c30bf44.jpg`,
    fotoAvatar: `${CAMINHO_ASSETS}_common/images/profiles/lucas.jpg`,
    galeria: [
      `${CAMINHO_ASSETS}_common/images/galleries/lucas/23b297a2ef2c60485591aebb6d976e94.jpg`,
      `${CAMINHO_ASSETS}_common/images/galleries/lucas/68156a8bc973df145c1d3c5c6c30bf44.jpg`,
      `${CAMINHO_ASSETS}_common/images/galleries/lucas/96bc01d703496ca37082bbfbbc46e985.jpg`,
      `${CAMINHO_ASSETS}_common/images/galleries/lucas/b03e235353501434fc666cfcc0d482cb.jpg`,
      `${CAMINHO_ASSETS}_common/images/galleries/lucas/b2371ef21ca51947ab36c1c71dfda4e9.jpg`,
      `${CAMINHO_ASSETS}_common/images/galleries/lucas/foto1.jpg`
    ]
  },
  {
    id: 'beatriz-souza',
    nome: 'Beatriz Souza',
    cidade: 'Maringá',
    estado: 'PR',
    especialidade: 'Casamentos',
    tags: ['Casamentos', 'Outdoor', 'Boho'],
    avaliacao: 4.9,
    totalAvaliacoes: 29,
    experiencia: '7 anos de experiência',
    descricao: 'Casamentos boho e celebrações ao ar livre. Estilo natural e atemporal.',
    descricaoCompleta: 'Fotografo casamentos em Maringá e toda a região norte do Paraná. Minha especialidade são celebrações ao ar livre — luz do fim do dia, cenários naturais e um estilo que vai envelhecer bem nas suas fotos.',
    fotoCapa: `${CAMINHO_ASSETS}_common/images/galleries/beatriz/35b5656c073fc5f500bdc94aefd2e39a.jpg`,
    fotoAvatar: `${CAMINHO_ASSETS}_common/images/profiles/beatriz.jpg`,
    galeria: [
      `${CAMINHO_ASSETS}_common/images/galleries/beatriz/24d35d989b990a085820c0d5e325ce81.jpg`,
      `${CAMINHO_ASSETS}_common/images/galleries/beatriz/35b5656c073fc5f500bdc94aefd2e39a.jpg`,
      `${CAMINHO_ASSETS}_common/images/galleries/beatriz/550027a23ae98f1de7ba058a78201745.jpg`,
      `${CAMINHO_ASSETS}_common/images/galleries/beatriz/73119f98971c6b702e3c4dd4cdfdcd24.jpg`,
      `${CAMINHO_ASSETS}_common/images/galleries/beatriz/a9c46451a22abd780112cd5bad3461a7.jpg`,
      `${CAMINHO_ASSETS}_common/images/galleries/beatriz/c6084719e2bf444d4dccff58c65827dc.jpg`
    ]
  },
  {
    id: 'andre-lima',
    nome: 'André Lima',
    cidade: 'Caxias do Sul',
    estado: 'RS',
    especialidade: 'Retrato',
    tags: ['Retrato', 'Marca pessoal', 'Corporativo'],
    avaliacao: 4.6,
    totalAvaliacoes: 15,
    experiencia: '3 anos de experiência',
    descricao: 'Retratos profissionais e ensaios de marca pessoal. Estúdio próprio.',
    descricaoCompleta: 'Trabalho com retratos profissionais e marca pessoal em Caxias do Sul. Tenho estúdio próprio com iluminação controlada e também realizo sessões externas. Ideal para profissionais que querem uma presença visual forte.',
    fotoCapa: `${CAMINHO_ASSETS}_common/images/galleries/andre/5397f5a4db3db71dff0834f2e1c83bb1.jpg`,
    fotoAvatar: `${CAMINHO_ASSETS}_common/images/profiles/andre.jpg`,
    galeria: [
      `${CAMINHO_ASSETS}_common/images/galleries/andre/16a41f021278c9284c9c6e711cec6e88.jpg`,
      `${CAMINHO_ASSETS}_common/images/galleries/andre/5397f5a4db3db71dff0834f2e1c83bb1.jpg`,
      `${CAMINHO_ASSETS}_common/images/galleries/andre/5917ffa6ba3854b72464a45211dde49f.jpg`,
      `${CAMINHO_ASSETS}_common/images/galleries/andre/754946624c937e41843b68030efd6bc2.jpg`,
      `${CAMINHO_ASSETS}_common/images/galleries/andre/b70471a3e80f53b161b9807a66febd5e.jpg`,
      `${CAMINHO_ASSETS}_common/images/galleries/andre/e4303eb42380157491c824b3c100c0a5.jpg`
    ]
  }
];
