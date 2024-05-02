import { collector, galaxy } from "@/lib/types";

const ActionSidebar = ({ collector: propCollector, galaxy: propGalaxy }: { collector?: collector, galaxy?: galaxy }) => {
    // Destructure props to avoid naming conflicts and make the code more readable

    // Check if propCollector exists and render accordingly
    if (propCollector) {
        return <div>Collector</div>;
    }

    // Check if propGalaxy exists and render accordingly
    if (propGalaxy) {
        return <div>Galaxy</div>;
    }

    // Default return if neither propCollector nor propGalaxy is provided
    return <div>No content to display</div>;
}

export default ActionSidebar;
