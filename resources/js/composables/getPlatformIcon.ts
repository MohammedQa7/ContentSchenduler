
export default function getPlatformIcon(platform: string) {
    switch (platform) {
        case 'Instagram':
            return 'InstagramIcon';
            break;
        case 'Linkedin':
            return 'LinkedinIcon';
            break;
        case 'Twitter':
            return 'TwitterIcon';
            break;
        default:
            return 'Icon';
            break;
    }
}